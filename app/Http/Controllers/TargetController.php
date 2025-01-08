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
            $query->where('first_name', 'like', '%' . $request->search . '%')->orWhere('last_name', 'like', '%' . $request->search . '%');
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
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'department' => 'required|integer|exists:target_departments,id',
            'email' => 'required|email|unique:targets,email',
            'position' => 'required|integer|exists:target_positions,id',
        ]);

        $target = new Target();
        $target->first_name = $request->first_name;
        $target->last_name = $request->last_name;
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
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'department' => 'required|integer|exists:target_departments,id',
            'email' => 'required|email',
            'position' => 'required|integer|exists:target_positions,id',
        ]);

        $target = Target::find($request->id);
        $original = [
            'first_name' => $target->first_name,
            'last_name' => $target->last_name,
            'email' => $target->email,
            'position' => $target->position_id,
        ];

        $target->first_name = $request->first_name;
        $target->last_name = $request->last_name;
        $target->department_id = $request->department;
        $target->email = $request->email;
        $target->position_id = $request->position;
        $target->save();
        if (
            $original['first_name'] !== $target->first_name ||
            $original['last_name'] !== $target->last_name ||
            $original['email'] !== $target->email || $original['position'] !== $target->position_id
        ) {
            GophishController::updateTarget($target, $original);
        }

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

    public function previewImportTarget(Request $request)
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
                    "RowColumns.*" => "size:6",
                    "RowColumns.*.0" => "distinct",
                    "RowColumns.*.1" => "max:256|required",
                    "RowColumns.*.2" => "max:256|required",
                    "RowColumns.*.3" => "max:256|required|email|unique:targets,email",
                    "RowColumns.*.4" => "exists:target_departments,id",
                    "RowColumns.*.5" => "exists:target_positions,id",
                ],
                [
                    "RowColumns.*.size" => "Invalid row at :attribute",
                    "RowColumns.*.0.distinct" => "Duplicate row at :attribute",
                    "RowColumns.*.1.required" => "First Name is required at :attribute",
                    "RowColumns.*.1.max" => "First Name is too long at :attribute",
                    "RowColumns.*.2.required" => "Last Name is required at :attribute",
                    "RowColumns.*.2.max" => "Last Name is too long at :attribute",
                    "RowColumns.*.3.required" => "Email is required at :attribute",
                    "RowColumns.*.3.unique" => "Email has been taken  at :attribute",
                    "RowColumns.*.3.email" => "Email is invalid at :attribute",
                    "RowColumns.*.3.max" => "Email is too long at :attribute",
                    "RowColumns.*.4.exists" => "Department not found at :attribute",
                    "RowColumns.*.5.exists" => "Position not found at :attribute",
                ]
            )->setAttributeNames(
                collect($csvRowsColumns->toArray())->mapWithKeys(function ($_, $index) {
                    return [
                        "RowColumns.$index" => "Row " . ($index + 1),
                        "RowColumns.$index.1" => "Row " . ($index + 1),
                        "RowColumns.$index.2" => "Row " . ($index + 1),
                        "RowColumns.$index.3" => "Row " . ($index + 1),
                        "RowColumns.$index.4" => "Row " . ($index + 1),
                        "RowColumns.$index.5" => "Row " . ($index + 1),
                    ];
                })->toArray()
            );

            if ($validator->errors()->any()) {
                return response()->json([
                    "errors" => $validator->errors()->all(),
                ], 400);
            }
            $targetCollection = Target::makeCollectionFromCsv($csvRowsColumns);
            if ($targetCollection->isEmpty()) {
                return response()->json([
                    "message" => "No valid data found in the file",
                    "success" => false,
                ], 422);
            }
            return response()->json([
                "message" => "Target imported successfully",
                "success" => true,
                "targets" => $targetCollection,
            ]);

        } else {
            $cantReadCsv = true;
        }
        if ($cantReadCsv) {
            return response()->json([
                "message" => "Can't read the file",
                "success" => false,
            ], 422);
        }
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
                    "RowColumns.*" => "size:6",
                    "RowColumns.*.0" => "distinct",
                    "RowColumns.*.1" => "max:256|required",
                    "RowColumns.*.2" => "max:256|required",
                    "RowColumns.*.3" => "max:256|required|email|unique:targets,email",
                    "RowColumns.*.4" => "exists:target_departments,id",
                    "RowColumns.*.5" => "exists:target_positions,id",
                ],
                [
                    "RowColumns.*.size" => "Invalid row at :attribute",
                    "RowColumns.*.0.distinct" => "Duplicate row at :attribute",
                    "RowColumns.*.1.required" => "First Name is required at :attribute",
                    "RowColumns.*.1.max" => "First Name is too long at :attribute",
                    "RowColumns.*.2.required" => "Last Name is required at :attribute",
                    "RowColumns.*.2.max" => "Last Name is too long at :attribute",
                    "RowColumns.*.3.required" => "Email is required at :attribute",
                    "RowColumns.*.3.email" => "Email is invalid at :attribute",
                    "RowColumns.*.3.unique" => "Email is already taken at :attribute",
                    "RowColumns.*.3.max" => "Email is too long at :attribute",
                    "RowColumns.*.4.exists" => "Department not found at :attribute",
                    "RowColumns.*.5.exists" => "Position not found at :attribute",
                ]
            )->setAttributeNames(
                collect($csvRowsColumns->toArray())->mapWithKeys(function ($_, $index) {
                    return [
                        "RowColumns.$index" => "Row " . ($index + 1),
                        "RowColumns.$index.1" => "Row " . ($index + 1),
                        "RowColumns.$index.2" => "Row " . ($index + 1),
                        "RowColumns.$index.3" => "Row " . ($index + 1),
                        "RowColumns.$index.4" => "Row " . ($index + 1),
                        "RowColumns.$index.5" => "Row " . ($index + 1),
                    ];
                })->toArray()
            );

            if ($validator->errors()->any()) {
                return response()->json([
                    "errors" => $validator->errors()->all(),
                ], 400);
            }
            $targetCollection = Target::makeCollectionFromCsvForImport($csvRowsColumns);
            if ($targetCollection->isEmpty()) {
                return response()->json([
                    "message" => "No valid data found in the file",
                    "success" => false,
                ], 422);
            }
            Target::insert($targetCollection->toArray());
            return response()->json([
                "message" => "Target imported successfully",
                "success" => true,
                "targets" => $targetCollection,
            ]);

        } else {
            $cantReadCsv = true;
        }
        if ($cantReadCsv) {
            return response()->json([
                "message" => "Can't read the file",
                "success" => false,
            ], 422);
        }
    }
}
