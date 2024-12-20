<?php

namespace App\Http\Controllers;

use App\Models\Target;
use App\Models\TargetDepartment;
use App\Models\TargetPosition;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    public function getTargetResources()
    {
        $department = TargetDepartment::all();
        $position = TargetPosition::all();
        return response()->json([
            'department' => $department,
            'position' => $position,
        ]);
    }

    public function getTargets(Request $request)
    {
        $query = Target::with('department', 'position')->where('company_id', auth()->user()->company_id);
        if ($request->has('search') && !empty($request->search) && $request->search != null) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->has('department') && !empty($request->department) && $request->department != null) {
            $query->where('department_id', $request->department);
        }
        if ($request->has('position') && !empty($request->position) && $request->position != null) {
            $query->where('position_id', $request->position);
        }
        $totalTarget = $query->count();
        $query = $query->paginate($request->show);
        $firstPageTotal = count($query->items());
        return response()->json([
            'targets' => $query->items(),
            'targetTotal' => $totalTarget,
            'currentPage' => $query->currentPage(),
            'firstPageTotal' => $firstPageTotal,
            'pageCount' => $query->lastPage(),

        ]);
    }

    public function createTarget(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|integer|exists:target_departments,id',
            'email' => 'required|email|unique:targets,email',
            'position' => 'required|integer|exists:target_positions,id',
        ]);

        $target = new Target();
        $target->name = $request->name;
        $target->department_id = $request->department;
        $target->email = $request->email;
        $target->position_id = $request->position;
        $target->company_id = auth()->user()->company_id;
        $target->save();

        return response()->json([
            'message' => 'Target created successfully',
            'success' => true,
        ]);
    }

    public function updateTarget(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:targets,id',
            'name' => 'required|string|max:255',
            'department' => 'required|integer|exists:target_departments,id',
            'email' => 'required|email',
            'position' => 'required|integer|exists:target_positions,id',
        ]);

        $target = Target::find($request->id);
        $target->name = $request->name;
        $target->department_id = $request->department;
        $target->email = $request->email;
        $target->position_id = $request->position;
        $target->save();

        return response()->json([
            'message' => 'Target updated successfully',
            'success' => true,
        ]);
    }

    public function deleteTarget(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:targets,id',
        ]);

        $target = Target::find($request->id);
        $target->delete();

        return response()->json([
            'message' => 'Target deleted successfully',
            'success' => true,
        ]);
    }
}
