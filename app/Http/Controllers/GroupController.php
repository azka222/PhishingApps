<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Target;
use App\Models\TargetDepartment;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;

class GroupController extends Controller
{
    public $url = 'http://127.0.0.1:3333/api';

    public function getTimeGoPhish()
    {
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('America/Chicago'));
        $formattedDate = $date->format('Y-m-d\TH:i:s.uP');
        return $formattedDate;
    }

    public function getIdFromGophish($module)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
        ])->get('http://127.0.0.1:3333/api/' . $module);
        $existingIds = collect($response->json())->pluck('id');
        $newId = $existingIds->max() + 1;
        return $newId;
    }

    public function getGroupResources()
    {
        $department = TargetDepartment::all();
        $users = auth()->user()->accessibleTarget()->get();
        return response()->json([
            'department' => $department,
            'users' => $users,
        ]);
    }
    public function getGroups(Request $request)
    {
        $query = auth()->user()->accessibleGroup();
        if ($request->has('status') && $request->status != null) {
            $query = $query->where('status', $request->status);
        }
        if ($request->has('department') && $request->department != 'null') {
            $query = $query->where('department_id', $request->department);
        }
        if(Gate::allows('IsAdmin')){
            if($request->has('companyId') && $request->companyId != null){
                $query = $query->where('company_id', $request->companyId);
            }
        }
        $ids = $query->pluck('gophish_id');
        $responses = [];
        foreach ($ids as $id) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
            ])->get("{$this->url}/groups/{$id}");
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['name'])) {
                    $data['name'] = explode('-+-', $data['name'])[0];
                }
                $group = auth()->user()->accessibleGroup()->where('gophish_id', $id)->first();
                $data['department'] = $group->department;
                $data['status'] = $group->status;
                $data['member'] = count($data['targets']);
                $data['description'] = $group->description;
                $data['department_id'] = $group->department_id;
                $data['targets'] = [];
                $data['targets'] = $group->target;
                $data['created_at'] = $group->created_at;
                $data['updated_at'] = $group->updated_at;
                $data['target_count'] = count($data['targets']);
                $responses[] = $data;

            }
        }
        $responseCollection = collect($responses);
        if ($request->has('search') && $request->search != null) {
            $responseCollection = $responseCollection->filter(function ($item) use ($request) {
                return stripos($item['name'], $request->search) !== false;
            });
        }
        $perPage = $request->has('show') ? (int) $request->show : 10;
        $currentPage = $request->has('page') ? (int) $request->page : 1;
        $pagedData = $responseCollection->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedData = new LengthAwarePaginator(
            $pagedData,
            $responseCollection->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        $totalGroup = $responseCollection->count();
        $firstPageTotal = $responseCollection->slice(0, $perPage)->count();
        return response()->json([
            'data' => $paginatedData->items(),
            'totalGroup' => $totalGroup,
            'currentPage' => $paginatedData->currentPage(),
            'firstPageTotal' => $firstPageTotal,
            'pageCount' => $paginatedData->lastPage(),
        ]);

    }
    public function createGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|',
            'department' => 'required|exists:target_departments,id',
            'status' => 'required|in:1,0',
            'members' => 'required|array|min:1',
            'members.*' => 'required|exists:targets,id',
            'description' => 'nullable',
        ]);
        $id = $this->getIdFromGophish('groups');
        $time = $this->getTimeGoPhish();

        $group = new Group();
        $group->gophish_id = $id;
        $group->department_id = $request->department;
        $group->status = $request->status;
        $group->description = $request->description;
        $group->company_id = auth()->user()->company_id;

        $targets = auth()->user()->accessibleTarget()->whereIn('id', $request->members)->get();
        $jsonTarget = [];
        foreach ($targets as $target) {
            $jsonTarget[] = [
                'first_name' => $target->first_name,
                'last_name' => $target->last_name,
                'email' => $target->email,
                'position' => $target->position->name,
            ];
        }

        $jsonData = [
            'id' => intval($id),
            'name' => $request->name . ' -+- ' . $id,
            'modified_date' => $time,
            'targets' => $jsonTarget,
        ];
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
        ])->post("{$this->url}/groups/", $jsonData);
        if ($response->successful() && $response->body() != []) {
            $group->save();
            $group->target()->sync($request->members);
            return response()->json([
                'message' => 'Group created successfully',
            ]);
        }
        return response()->json(['error' => $response->json()], 500);

    }

    public function updateGroup(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:groups,gophish_id',
            'name' => 'required',
            'department' => 'required|exists:target_departments,id',
            'status' => 'required|in:1,0',
            'members' => 'required|array|min:1',
            'members.*' => 'required|exists:targets,id',
            'description' => 'nullable',
        ]);

        $group = auth()->user()->accessibleGroup()->where('gophish_id', $request->id)->first();
        $group->department_id = $request->department;
        $group->status = $request->status;
        $group->description = $request->description;
        $targets = auth()->user()->accessibleTarget()->whereIn('id', $request->members)->get();
        $jsonTarget = [];
        foreach ($targets as $target) {
            $jsonTarget[] = [
                'first_name' => $target->first_name,
                'last_name' => $target->last_name,
                'email' => $target->email,
                'position' => $target->position->name,
            ];
        }
        $jsonData = [
            'id' => intval($request->id),
            'name' => $request->name . ' -+- ' . $request->id,
            'modified_date' => $this->getTimeGoPhish(),
            'targets' => $jsonTarget,
        ];
        $idGroup = intval($request->id);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
        ])->put("{$this->url}/groups/{$idGroup}", $jsonData);
        if ($response->successful() && $response->body() != []) {
            $group->save();
            $group->target()->sync($request->members);
            return response()->json([
                'message' => 'Group updated successfully',
            ]);
        }
        return response()->json(['error' => $response->json()], 500);
    }

    public function deleteGroup(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:groups,gophish_id',
        ]);

        $group = auth()->user()->accessibleGroup()->where('gophish_id', $request->id)->first();
        $id = intval($request->id);
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
        ])->delete("{$this->url}/groups/{$id}");
        if ($response->successful() && $response->body() != []) {
            $group->delete();
            return response()->json([
                'message' => 'Group deleted successfully',
            ]);
        }
        return response()->json(['error' => $response->json()], 500);
    }

}
