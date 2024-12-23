<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Target;
use App\Models\TargetDepartment;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function getGroupResources()
    {
        $department = TargetDepartment::all();
        $users = Target::with('department')->where('company_id', auth()->user()->company_id)->get();
        return response()->json([
            'department' => $department,
            'users' => $users,
        ]);
    }
    public function getGroups(Request $request)
    {
        $query = Group::with('department', 'target.department', 'target.position')
            ->withCount('target')
            ->where('company_id', auth()->user()->company_id);
        if ($request->has('search') && $request->search != null) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->has('department') && $request->department != null && $request->department != 'null') {
            $query->where('department_id', $request->department);
        }
        if ($request->has('status') && $request->status != null) {
            $query->where('status', $request->status);
        }
        $totalGroup = $query->count();
        $query = $query->paginate($request->show);
        $firstPageTotal = count($query->items());
        return response()->json([
            'groups' => $query->items(),
            'targetTotal' => $totalGroup,
            'currentPage' => $query->currentPage(),
            'firstPageTotal' => $firstPageTotal,
            'pageCount' => $query->lastPage(),

        ]);
    }

    public function createGroup(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'department' => 'required|exists:target_departments,id',
            'status' => 'required|in:1,0',
            'members' => 'required|array|min:1',
            'members.*' => 'required|exists:targets,id',
            'description' => 'nullable',
        ]);

        $group = new Group();
        $group->name = $request->name;
        $group->department_id = $request->department;
        $group->status = $request->status;
        $group->description = $request->description;
        $group->company_id = auth()->user()->company_id;
        $group->save();

        $group->target()->sync($request->members);

        return response()->json([
            'message' => 'Group created successfully',
        ]);

    }

    public function updateGroup(Request $request){
        $request->validate([
            'id' => 'required|exists:groups,id',
            'name' => 'required',
            'department' => 'required|exists:target_departments,id',
            'status' => 'required|in:1,0',
            'members' => 'required|array|min:1',
            'members.*' => 'required|exists:targets,id',
            'description' => 'nullable',
        ]);

        $group = Group::find($request->id);
        $group->name = $request->name;
        $group->department_id = $request->department;
        $group->status = $request->status;
        $group->description = $request->description;
        $group->save();

        $group->target()->sync($request->members);

        return response()->json([
            'message' => 'Group updated successfully',
        ]);
    }

    public function deleteGroup(Request $request){
        $request->validate([
            'id' => 'required|exists:groups,id',
        ]);

        $group = Group::find($request->id);
        $group->delete();

        return response()->json([
            'message' => 'Group deleted successfully',
        ]);
    }

}
