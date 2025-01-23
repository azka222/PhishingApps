<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function getAllUser(Request $request)
    {
        if (Gate::allows('IsAdmin')) {
            $user = User::with('company')->where('is_admin', 0);
            if ($request->has('search') && ! empty($request->search)) {
                $searchTerms = explode(' ', $request->search);
                $user->where(function ($query) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $query->where('first_name', 'like', '%' . $term . '%')
                            ->orWhere('last_name', 'like', '%' . $term . '%');
                    }
                });
            }

            if ($request->has('status') && $request->status == 1) {
                $user->where('email_verified_at', '!=', null);
            } else if ($request->has('status') && $request->status == 0 && $request->status != null) {
                $user->where('email_verified_at', '=', null);
            }
            if ($request->has('company') && $request->company != null) {
                $user->where('company_id', $request->company);
            }
            $totalUser      = $user->count();
            $user           = $user->paginate($request->show);
            $firstPageTotal = count($user->items());
            return response()->json([
                'users'          => $user->items(),
                'userTotal'      => $totalUser,
                'currentPage'    => $user->currentPage(),
                'firstPageTotal' => $firstPageTotal,
                'pageCount'      => $user->lastPage(),

            ]);
        }

    }

    public function getAllCompany(Request $request)
    {
        if (Gate::allows('IsAdmin')) {
            $company = Company::with('user');
            if ($request->has('search') && ! empty($request->search)) {
                $searchTerms = explode(' ', $request->search);
                $company->where(function ($query) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $query->where('name', 'like', '%' . $term . '%');
                    }
                });
            }
            if ($request->has('status') && $request->status != null) {
                $company->where('visibility_id', $request->status);
            }
            $totalCompany = $company->count();
            $company      = $company->paginate($request->show);
            return response()->json([
                'companies'      => $company->items(),
                'companyTotal'   => $totalCompany,
                'currentPage'    => $company->currentPage(),
                'firstPageTotal' => count($company->items()),
                'pageCount'      => $company->lastPage(),
            ]);
        }
    }

    public function editUser(Request $request)
    {

        if (Gate::allows('IsAdmin')) {
            $request->validate([
                'id'         => 'required',
                'first_name' => 'required',
                'last_name'  => 'required',
                'email'      => 'required|email',
                'phone'      => 'required',
            ]);
            $user                    = User::find($request->id);
            $user->first_name        = $request->first_name;
            $user->last_name         = $request->last_name;
            $user->email             = $request->email;
            $user->phone             = $request->phone;
            $user->email_verified_at = $request->verified == 1 ? Carbon::now() : null;
            $user->save();
            return response()->json([
                'message' => 'User updated successfully',
                'status'  => 'success',
            ]);
        } else {
            return response()->json([
                'message' => 'You are not authorized to perform this action',
                'status'  => 'error',
            ], 403);
        }
    }

    public function deleteUser(Request $request)
    {
        if (Gate::allows('IsAdmin')) {
            $request->validate([
                'id' => 'required',
            ]);
            $user = User::find($request->id);
            $user->delete();
            return response()->json([
                'message' => 'User deleted successfully',
                'status'  => 'success',
            ]);
        } else {
            return response()->json([
                'message' => 'You are not authorized to perform this action',
                'status'  => 'error',
            ], 403);
        }
    }
    public function editCompany(Request $request){
        if (Gate::allows('IsAdmin')) {
            $request->validate([
                'id'          => 'required',
                'name'        => 'required',
                'email'       => 'required|email',
                'visibility'  => 'required',
                'max_account' => 'required|integer',
                'owner'       => 'required|exists:users,id',
                'status'      => 'required|integer',
            ]);

            $company = Company::with('user')->where('id', $request->id)->first();
            $company->name = $request->name;
            $company->email = $request->email;
            $company->visibility_id = $request->visibility == 1 ? 1 : 2;    
            $company->max_account = $request->max_account;
            $company->user_id =$request->owner;
            $company->status_id = $request->status == 1 ? 1 : 2;
            $company->user->save();
            $company->save();
            return response()->json([
                'message' => 'Company updated successfully',
                'status'  => 'success',
            ]);
        }
        else{
            return response()->json([
                'message' => 'You are not authorized to perform this action',
                'status'  => 'error',
            ],403);
        }
    }
    
    public function getUsersByCompanyId($company_id)
    {
        $users = User::where('company_id', $company_id)->get(); // Menyesuaikan query sesuai dengan tabel users
        return response()->json([
            'status' => 'success',
            'users' => $users
        ]);
    }
    
    
    public function deleteCompany(Request $request)
    {
        if (Gate::allows('IsAdmin')) {
            $request->validate([
                'id' => 'required',
            ]);
            $company = Company::find($request->id);
            $company->delete();
            return response()->json([
                'message' => 'Company deleted successfully',
                'status'  => 'success',
            ]);
        } else {
            return response()->json([
                'message' => 'You are not authorized to perform this action',
                'status'  => 'error',
            ], 403);
        }
    }

    public function userGetIdCompanyUser(Request $request)
    {
        if (Gate::allows('IsAdmin')) {
            $user = User::where('company_id', $request->company_id)->get();
            return response()->json([
                'users' => $user,
            ]);
        }
    }
}

