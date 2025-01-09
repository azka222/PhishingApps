<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CompanyCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ViewController extends Controller
{
    public static function getCompanies()
    {
        if (Gate::allows("IsAdmin")) {
            return \App\Models\Company::all();
        }
        return \App\Models\Company::whereRaw(0);
    }
    public function loginView()
    {
        return view('auth.login');
    }

    public function registerView()
    {
        return view('auth.register');
    }

    public function userSettingView()
    {
        return view('contents.user-setting');
    }

    public function forgotPasswordView()
    {
        return view('auth.forgot-password');
    }

    public function resetPasswordView(Request $request)
    {
        $token = $request->query('token');
        if (!$token) {
            return redirect('/')->with('error', 'Invalid token.');
        }
        return view('auth.reset-password', ['token' => $token]);
    }

    public function targetView()
    {
        $companies = $this->getCompanies();
        return view('contents.target', ['companies' => $companies]);
    }

    public function groupView()
    {
        $companies = $this->getCompanies();
        return view('contents.group', ['companies' => $companies]);

    }

    public function landingPageView()
    {
        return view('contents.landing-page');
    }

    public function emailTemplatesView()
    {

        $companies = $this->getCompanies();
        return view('contents.email-templates', ['companies' => $companies]);
    }

    public function sendingProfileView()
    {
        $companies = $this->getCompanies();
        return view('contents.sending-profiles', ['companies' => $companies]);
    }

    public function campaignView()
    {
        $companies = $this->getCompanies();
        return view('contents.campaign', ['companies' => $companies]);
    }

    public function campaignDetailsView($id)
    {
        $check = CompanyCampaign::where('company_id', auth()->user()->company_id)->where('campaign_id', $id)->first();
        if (!$check) {
            abort(404);
        }
        return view('contents.campaign-details', ['id' => $id]);
    }
}
