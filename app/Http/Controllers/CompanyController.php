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
        $companies = Company::all();
        return response()->json([
            'status' => 'success',
            'data' => $companies
        ]);
    }

    public function checkCompany(Request $request){
        $request->validate([
            'id' => 'required|integer|exists:companies,id'
        ]);
        $company = Company::findOrFail( $request->id)->user;
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
        $company->user = 1;
        $company->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Company created successfully',
        ]);
    }
}
