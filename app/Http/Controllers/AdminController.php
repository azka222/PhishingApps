<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function getAllUser(Request $request)
    {
        if (Gate::allows('IsAdmin')) {
            $user = User::with('company');
            if ($request->has('search') && !empty($request->search)) {
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
            $totalUser = $user->count();
            $user = $user->paginate($request->show);
            $firstPageTotal = count($user->items());
            return response()->json([
                'users' => $user->items(),
                'userTotal' => $totalUser,
                'currentPage' => $user->currentPage(),
                'firstPageTotal' => $firstPageTotal,
                'pageCount' => $user->lastPage(),

            ]);
        }

    }

    public function getAllCompany()
    {
        if (Gate::allows('IsAdmin')) {
            return Company::with('user')->get();
        }
    }
}
