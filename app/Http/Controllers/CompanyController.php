<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Role;
use App\Models\RoleModuleAbilities;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getCompanies()
    {
        $companies = Company::where('visibility_id', 1)->get();
        return response()->json([
            'status' => 'success',
            'data'   => $companies,
        ]);
    }

    public function checkCompany(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:companies,id',
        ]);
        $company   = Company::findOrFail($request->id)->max_account;
        $userCount = User::where('company_id', $request->id)->count();
        if ($userCount < $company) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Company is available',
            ]);
        } else {
            return response()->json([
                'status'  => 'error',
                'message' => 'Cannot use this company',
                'suggest' => 'Please contact the company admin or create a new one.',
            ], 400);
        }
    }

    public function createCompany(Request $request)
    {
        $request->validate([
            'name'    => 'required|string',
            'email'   => 'required|email',
            'address' => 'required|string',
        ]);

        $company                = new Company();
        $company->name          = $request->name;
        $company->address       = $request->address;
        $company->email         = $request->email;
        $company->max_account   = 1;
        $company->status_id     = 1;
        $company->visibility_id = 1;
        $company->save();
        return response()->json([
            'status'  => 'success',
            'message' => 'Company created successfully',
        ]);
    }

    public function getCompanyDetails()
    {
        if (Gate::allows('IsCompanyOwner')) {
            $company = Company::with('status', 'visibility', 'user')->where('id', auth()->user()->company_id)->first();
            return response()->json([
                'status' => 'success',
                'data'   => $company,
            ]);
        } else {
            return response()->json([
                'status'  => 'error',
                'message' => 'You are not allowed to view company details',
            ], 403);
        }
    }

    public function updateCompany(Request $request)
    {
        $request->validate([
            'name'          => 'required|string',
            'email'         => 'required|email',
            'address'       => 'required|string',
            'max_account'   => 'required|integer|min:1',
            'status_id'     => 'required|integer|exists:company_statuses,id',
            'visibility_id' => 'required|integer|exists:company_visibilities,id',
        ]);

        $company                = Company::findOrFail(auth()->user()->company_id);
        $company->name          = $request->name;
        $company->address       = $request->address;
        $company->email         = $request->email;
        $company->max_account   = $request->max_account;
        $company->status_id     = $request->status_id;
        $company->visibility_id = $request->visibility_id;
        $company->save();
        return response()->json([
            'status'  => 'success',
            'message' => 'Company updated successfully',
        ]);
    }

    public function getCompanyUsers()
    {
        $users = User::with('role')->where('company_id', auth()->user()->company_id)->get();
        return response()->json([
            'status' => 'success',
            'data'   => $users,
        ]);
    }

    public function getRoles()
    {
        $roles = Role::where('company_id', auth()->user()->company_id)->get();
        return response()->json([
            'status' => 'success',
            'data'   => $roles,
        ]);
    }

    public function getRoleDetails(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:roles,id',
        ]);
        $roleModuleAbility = RoleModuleAbilities::where('role_id', $request->id)->get();
        return response()->json([
            'status' => 'success',
            'data'   => $roleModuleAbility,
            'role'   => Role::findOrFail($request->id),
        ]);
    }

    public function updateRole(Request $request)
    {
        $request->validate([
            'id'     => 'required|integer|exists:roles,id',
            'name'   => 'required|string',
            'access' => 'required|array',
        ]);

        $role       = Role::findOrFail($request->id);
        $role->name = $request->name;
        $role->save();

        if ($request->has('access') && is_array($request->access)) {
            $role->moduleAbility()->sync($request->access);
        }
        return response()->json([
            'status'  => 'success',
            'message' => 'Role updated successfully',
        ]);
    }

    public function createRole(request $request)
    {
        $request->validate([
            'name'   => 'required|string',
            'access' => 'nullable|array',
        ]);
        if (Gate::allows('IsCompanyOwner')) {
            $role             = new Role();
            $role->name       = $request->name;
            $role->company_id = auth()->user()->company_id;
            $role->save();
            if ($request->has('access') && is_array($request->access)) {
                $role->moduleAbility()->sync($request->access);
            }
            return response()->json([
                'status'  => 'success',
                'message' => 'Role created successfully',
            ]);
        } else {
            return response()->json([
                'status'  => 'error',
                'message' => 'You are not allowed to create role',
            ], 403);
        }
    }

    public function deleteRole(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:roles,id',
        ]);
        if (Gate::allows('IsCompanyOwner')) {
            if (Role::findOrFail($request->id)->users()->count() > 0) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Role is in use',
                ], 400);
            }
            $role = Role::findOrFail($request->id);
            $role->moduleAbility()->detach();
            $role->delete();
            return response()->json([
                'status'  => 'success',
                'message' => 'Role deleted successfully',
            ]);
        } else {
            return response()->json([
                'status'  => 'error',
                'message' => 'You are not allowed to delete role',
            ], 403);
        }
    }

    public function updateUserCompany(Request $request)
    {
        $request->validate([
            'id'         => 'required|integer|exists:users,id',
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'phone'      => ['required', 'string', 'regex:/^08[0-9]{7,10}$/', 'min:10', 'max:13'],
            'email'      => 'required|email',
            'role_id'    => 'required|integer|exists:roles,id',
        ]);

        if (Gate::allows('IsCompanyOwner', auth()->user()->company_id)) {
            $user             = User::findOrFail($request->id);
            $user->first_name = $request->first_name;
            $user->last_name  = $request->last_name;
            $user->phone      = $request->phone;
            $user->email      = $request->email;
            $user->role_id    = $request->role_id;
            $user->save();
            return response()->json([
                'status'  => 'success',
                'message' => 'User updated successfully',
            ]);

        } else {
            return response()->json([
                'status'  => 'error',
                'message' => 'You are not allowed to update user',
            ], 403);
        }
    }
}
