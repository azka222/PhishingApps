<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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
            'data' => $companies
        ]);
    }

    public function checkCompany(Request $request){
        $request->validate([
            'id' => 'required|integer|exists:companies,id'
        ]);
        $company = Company::findOrFail( $request->id)->max_account;
        $userCount = User::where('company_id', $request->id)->count();
        if($userCount < $company){
            return response()->json([
                'status' => 'success',
                'message' => 'Company is available'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot use this company',
                'suggest' => 'Please contact the company admin or create a new one.'
            ], 400);
        }
    }

    public function createCompany(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string'
        ]);
   
        $company = new Company();
        $company->name = $request->name;
        $company->address = $request->address;
        $company->email = $request->email;
        $company->max_account = 1;
        $company->status_id = 1;
        $company->visibility_id = 1;
        $company->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Company created successfully',
        ]);
    }

    public function getCompanyDetails(){
        $company = Company::with('status', 'visibility', 'user')->where('id', auth()->user()->company_id)->first();
        return response()->json([
            'status' => 'success',
            'data' => $company
        ]);
    }

    public function updateCompany(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'max_account' => 'required|integer|min:1',
            'status_id' => 'required|integer|exists:company_statuses,id',
            'visibility_id' => 'required|integer|exists:company_visibilities,id'
        ]);

        $company = Company::findOrFail(auth()->user()->company_id);
        $company->name = $request->name;
        $company->address = $request->address;
        $company->email = $request->email;
        $company->max_account = $request->max_account;
        $company->status_id = $request->status_id;
        $company->visibility_id = $request->visibility_id;
        $company->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Company updated successfully',
        ]);
    }
}
