<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Models\Target;
use App\Models\TargetDepartment;
use App\Models\TargetPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function importTarget(Request $request)
    {
        $request->validate([
            'target' => 'required|file|mimes:csv,txt',
            'separator' => 'required|string',
        ]);
        $cantReadCsv = false;
        $targetCsv = $request->file("target")->get();
        $projectsSeparator = $request->input("separator", ',');
        if ($targetCsv) {
            $targetCsv = trim($targetCsv, "\n");
            $csvRowsColumns = FileHelper::convertCsvToCollection($targetCsv, $projectsSeparator);
            $csvRowsColumns->shift();
            $validator = Validator::make(
                ["RowColumns" => $csvRowsColumns->toArray()],
                [
                    "RowColumns.*" => "size:5",
                    "RowColumns.*.0" => "distinct",
                    "RowColumns.*.1" => "max:256 | required",
                    "RowColumns.*.2" => "max:256 | required",
                    "RowColumns.*.3" => "exists:target_departments,id",
                    "RowColumns.*.4" => "exists:target_positions,id",            
        
                ],
                [
                    "RowColumns.*.1.required" => "Name is required at :attribute",
                    "RowColumns.*.1.max" => "Name is too long at :attribute",
                    "RowColumns.*.2.required" => "Email is required at :attribute",
                    "RowColumns.*.2.max" => "Email is too long at :attribute",
                    "RowColumns.*.3.exists" => "Department not found at :attribute",
                    "RowColumns.*.4.exists" => "Position not found at :attribute",

                ]
            )->setAttributeNames(
                collect($csvRowsColumns)->mapWithKeys(function ($_, $index) {
                    return [
                        "RowColumns.$index.1" => "Row " . ($index + 1),
                        "RowColumns.$index.2" => "Row " . ($index + 1),
                        "RowColumns.$index.3" => "Row " . ($index + 1),
                    ];
                })->toArray()
            );

            if ($validator->errors()->any()) {
                return response()->json([
                    "errors" => $validator->errors()->all(),
                ], 400);
            }
            dd($csvRowsColumns);
        } else {
            $cantReadCsv = true;
        }
    }
}
