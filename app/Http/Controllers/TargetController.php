<?php
namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Jobs\SendAccountCredentials;
use App\Models\Target;
use App\Models\TargetDepartment;
use App\Models\TargetPosition;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TargetController extends Controller
{
    public function getTargetResources()
    {
        $department = TargetDepartment::all();
        $position   = TargetPosition::all();
        return response()->json([
            'department' => $department,
            'position'   => $position,
        ]);
    }

    public function getTargets(Request $request)
    {
        if (Gate::allows('CanReadTarget')) {
            $query = auth()->user()->accessibleTarget();
            if ($request->has('search') && ! empty($request->search)) {
                $searchTerm = $request->search;
                $query->where(function ($check) use ($searchTerm) {
                    $check->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$searchTerm}%"]);
                });
            }

            if ($request->has('department') && ! empty($request->department) && $request->department != null) {
                $query->where('department_id', $request->department);
            }
            if ($request->has('position') && ! empty($request->position) && $request->position != null) {
                $query->where('position_id', $request->position);
            }
            if (Gate::allows("IsAdmin")) {
                if ($request->has('companyId') && ! empty($request->companyId) && $request->companyId != null) {
                    $query->where('company_id', $request->companyId);
                }
            }
            $totalTarget    = $query->count();
            $query          = $query->paginate($request->show);
            $firstPageTotal = count($query->items());
            return response()->json([
                'targets'        => $query->items(),
                'targetTotal'    => $totalTarget,
                'currentPage'    => $query->currentPage(),
                'firstPageTotal' => $firstPageTotal,
                'pageCount'      => $query->lastPage(),

            ]);
        } else {
            abort(403);
        }
    }

    public function createTarget(Request $request)
    {
        if (Gate::allows('CanCreateTarget')) {
            $request->validate([
                'first_name'    => 'required|string|max:50',
                'last_name'     => 'required|string|max:50',
                'department'    => 'required|integer|exists:target_departments,id',
                'email'         => 'required|email|unique:targets,email',
                'position'      => 'required|integer|exists:target_positions,id',
                'createAccount' => 'required|',
                'targetAge'     => 'required|integer|min:1|max:100',
            ]);

            // dd($request->targetAge);

            if (auth()->user()->adminCheck()) {
                $request->validate([
                    'company' => 'required|integer|exists:companies,id',
                ]);
            }

            $target                = new Target();
            $target->first_name    = $request->first_name;
            $target->last_name     = $request->last_name;
            $target->department_id = $request->department;
            $target->email         = $request->email;
            $target->position_id   = $request->position;
            $target->age           = $request->targetAge;
            $target->company_id    = auth()->user()->adminCheck() ? $request->company : auth()->user()->company_id;
            $target->save();

            if ($request->createAccount) {
                $existingUser = User::where('email', $request->email)->first();
                if (! $existingUser) {
                    $password         = Str::random(12);
                    $user             = new User();
                    $user->first_name = $request->first_name;
                    $user->last_name  = $request->last_name;
                    $user->email      = $request->email;
                    $user->password   = Hash::make($password);
                    $user->phone      = '081234567890';
                    $user->gender     = 'aaa';
                    $user->employee   = 1;
                    $user->is_admin   = 0;
                    $user->role_id    = null;
                    $user->company_id = auth()->user()->adminCheck() ? $request->company : auth()->user()->company_id;
                    $user->save();
                    SendAccountCredentials::dispatch($user->email, $password, $user->first_name);
                    $target->has_account = true;
                    $target->save();
                } else {
                    return response()->json([
                        'message' => 'Email already exists',
                        'success' => false,
                    ], 422);
                }
            }

            return response()->json([
                'message' => 'Target created successfully',
                'success' => true,
            ]);
        } else {
            return response()->json([
                'message' => 'You are not authorized to perform this action',
                'success' => false,
            ], 403);
        }

    }

    public function updateTarget(Request $request)
    {
        if (Gate::allows('CanUpdateTarget')) {
            $request->validate([
                'id'            => 'required|integer|exists:targets,id',
                'first_name'    => 'required|string|max:50',
                'last_name'     => 'required|string|max:50',
                'department'    => 'required|integer|exists:target_departments,id',
                'email'         => 'required|email',
                'position'      => 'required|integer|exists:target_positions,id',
                'createAccount' => 'required|',
                'targetAge'     => 'required|integer|min:1|max:100',
            ]);

            $target   = auth()->user()->accessibleTarget()->where('id', $request->id)->first();
            $original = [
                'first_name' => $target->first_name,
                'last_name'  => $target->last_name,
                'email'      => $target->email,
                'position'   => $target->position_id,
            ];
            $oldEmail              = $target->email;
            $target->first_name    = $request->first_name;
            $target->last_name     = $request->last_name;
            $target->department_id = $request->department;
            $target->position_id   = $request->position;
            $target->age           = $request->targetAge;
            $target->save();
            if ($request->createAccount == 1) {
                $existingUser = User::where('email', $oldEmail)->first();
                if ($oldEmail !== $request->email) {
                    return response()->json([
                        'message' => 'You cannot change the email address',
                        'success' => false,
                    ], 422);
                }
                if (! $existingUser) {
                    $password         = Str::random(12);
                    $user             = new User();
                    $user->first_name = $request->first_name;
                    $user->last_name  = $request->last_name;
                    $user->email      = $request->email;
                    $user->password   = Hash::make($password);
                    $user->phone      = '081234567890';
                    $user->gender     = 'aaa';
                    $user->employee   = 1;
                    $user->company_id = auth()->user()->adminCheck() ? $request->company : auth()->user()->company_id;
                    $user->save();
                    SendAccountCredentials::dispatch($user->email, $password, $user->first_name);
                    $target->has_account = true;
                    $target->save();
                } else {
                    if($existingUser->email !== $request->email) {
                        return response()->json([
                            'message' => 'Email already exists',
                            'success' => false,
                        ], 422);
                    }
                    $existingUser->first_name = $request->first_name;
                    $existingUser->last_name  = $request->last_name;
                }
            } else {
                $target->email = $request->email;
                $target->save();
            }
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
        } else {
            return response()->json([
                'message' => 'You are not authorized to perform this action',
                'success' => false,
            ], 403);
        }
    }

    public function deleteTarget(Request $request)
    {
        if (Gate::allows('CanDeleteTarget')) {
            $request->validate([
                'id' => 'required|integer|exists:targets,id',
            ]);

            $target = auth()->user()->accessibleTarget()->where('id', $request->id)->first();
            $user = User::where('email', $target->email)->first();
            if ($user && $target->has_account) {
                $user->delete();
            }
            $target->delete();
            return response()->json([
                'message' => 'Target deleted successfully',
                'success' => true,
            ]);
        } else {
            return response()->json([
                'message' => 'You are not authorized to perform this action',
                'success' => false,
            ], 403);
        }
    }

    public function previewImportTarget(Request $request)
    {
        $request->validate([
            'target'    => 'required|file|mimes:csv,txt',
            'separator' => 'required|string',
        ]);
        $cantReadCsv       = false;
        $targetCsv         = $request->file("target")->get();
        $projectsSeparator = $request->input("separator", ',');
        if ($targetCsv) {
            $targetCsv      = trim($targetCsv, "\n");
            $csvRowsColumns = FileHelper::convertCsvToCollection($targetCsv, $projectsSeparator);
            $csvRowsColumns->shift();
            $validator = Validator::make(
                ["RowColumns" => $csvRowsColumns->toArray()],
                [
                    "RowColumns.*"   => "size:7",
                    "RowColumns.*.0" => "distinct",
                    "RowColumns.*.1" => "max:256|required",
                    "RowColumns.*.2" => "max:256|required",
                    "RowColumns.*.3" => "max:256|required|email|unique:targets,email",
                    "RowColumns.*.4" => "exists:target_departments,id",
                    "RowColumns.*.5" => "exists:target_positions,id",
                    "RowColumns.*.6" => "required|min:1|max:100",
                ],
                [
                    "RowColumns.*.size"       => "Invalid row at :attribute",
                    "RowColumns.*.0.distinct" => "Duplicate row at :attribute",
                    "RowColumns.*.1.required" => "First Name is required at :attribute",
                    "RowColumns.*.1.max"      => "First Name is too long at :attribute",
                    "RowColumns.*.2.required" => "Last Name is required at :attribute",
                    "RowColumns.*.2.max"      => "Last Name is too long at :attribute",
                    "RowColumns.*.3.required" => "Email is required at :attribute",
                    "RowColumns.*.3.unique"   => "Email has been taken  at :attribute",
                    "RowColumns.*.3.email"    => "Email is invalid at :attribute",
                    "RowColumns.*.3.max"      => "Email is too long at :attribute",
                    "RowColumns.*.4.exists"   => "Department not found at :attribute",
                    "RowColumns.*.5.exists"   => "Position not found at :attribute",
                    "RowColumns.*.6.integer"  => "Age must be a number at :attribute",
                ]
            )->setAttributeNames(
                collect($csvRowsColumns->toArray())->mapWithKeys(function ($_, $index) {
                    return [
                        "RowColumns.$index"   => "Row " . ($index + 1),
                        "RowColumns.$index.1" => "Row " . ($index + 1),
                        "RowColumns.$index.2" => "Row " . ($index + 1),
                        "RowColumns.$index.3" => "Row " . ($index + 1),
                        "RowColumns.$index.4" => "Row " . ($index + 1),
                        "RowColumns.$index.5" => "Row " . ($index + 1),
                        "RowColumns.$index.6" => "Row " . ($index + 1),
                    ];
                })->toArray()
            );
            // dd($csvRowsColumns->toArray());

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
        if (Gate::allows('CanCreateTarget')) {
            $request->validate([
                'target'    => 'required|file|mimes:csv,txt',
                'separator' => 'required|string',
            ]);
            $cantReadCsv       = false;
            $targetCsv         = $request->file("target")->get();
            $projectsSeparator = $request->input("separator", ',');
            if ($targetCsv) {
                $targetCsv      = trim($targetCsv, "\n");
                $csvRowsColumns = FileHelper::convertCsvToCollection($targetCsv, $projectsSeparator);
                $csvRowsColumns->shift();

                $validator = Validator::make(
                    ["RowColumns" => $csvRowsColumns->toArray()],
                    [
                        "RowColumns.*"   => "size:7",
                        "RowColumns.*.0" => "distinct",
                        "RowColumns.*.1" => "max:256|required",
                        "RowColumns.*.2" => "max:256|required",
                        "RowColumns.*.3" => "max:256|required|email|unique:targets,email",
                        "RowColumns.*.4" => "exists:target_departments,id",
                        "RowColumns.*.5" => "exists:target_positions,id",
                        "RowColumns.*.6" => "required|integer|min:1|max:100",
                    ],
                    [
                        "RowColumns.*.size"       => "Invalid row at :attribute",
                        "RowColumns.*.0.distinct" => "Duplicate row at :attribute",
                        "RowColumns.*.1.required" => "First Name is required at :attribute",
                        "RowColumns.*.1.max"      => "First Name is too long at :attribute",
                        "RowColumns.*.2.required" => "Last Name is required at :attribute",
                        "RowColumns.*.2.max"      => "Last Name is too long at :attribute",
                        "RowColumns.*.3.required" => "Email is required at :attribute",
                        "RowColumns.*.3.email"    => "Email is invalid at :attribute",
                        "RowColumns.*.3.unique"   => "Email is already taken at :attribute",
                        "RowColumns.*.3.max"      => "Email is too long at :attribute",
                        "RowColumns.*.4.exists"   => "Department not found at :attribute",
                        "RowColumns.*.5.exists"   => "Position not found at :attribute",
                        "RowColumns.*.6.integer"  => "Age must be a number at :attribute",
                        "RowColumns.*.6.min"      => "Age must be at least 1 at :attribute",
                        "RowColumns.*.6.max"      => "Age must be at most 100 at :attribute",
                        "RowColumns.*.6.required" => "Age is required at :attribute",
                    ]
                )->setAttributeNames(
                    collect($csvRowsColumns->toArray())->mapWithKeys(function ($_, $index) {
                        return [
                            "RowColumns.$index"   => "Row " . ($index + 1),
                            "RowColumns.$index.1" => "Row " . ($index + 1),
                            "RowColumns.$index.2" => "Row " . ($index + 1),
                            "RowColumns.$index.3" => "Row " . ($index + 1),
                            "RowColumns.$index.4" => "Row " . ($index + 1),
                            "RowColumns.$index.5" => "Row " . ($index + 1),
                            "RowColumns.$index.6" => "Row " . ($index + 1),
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
        } else {
            return response()->json([
                'message' => 'You are not authorized to perform this action',
                'success' => false,
            ], 403);
        }
    }

    public function downloadTemplateTarget()
    {
        $filePath = storage_path('template/templateImportTarget.zip');
        return response()->download($filePath, 'template.zip');

    }

}
