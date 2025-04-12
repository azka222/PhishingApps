<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

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

    public function dashboardView()
    {
        if (Gate::allows('CanAccessDashboard')) {
            return view('contents.page.dashboard');
        } else {
            return redirect()->route('userSettingView');
        }
    }

    public function userSettingView()
    {
        $modules          = Module::with(['moduleAbilities.ability'])->get();
        $formattedModules = $modules->map(function ($module) {
            return [
                'module_name' => $module->name,
                'abilities'   => $module->moduleAbilities->map(function ($moduleAbility) {
                    return [
                        'id'                => $moduleAbility->ability->id,
                        'name'              => $moduleAbility->ability->name,
                        'id_module_ability' => $moduleAbility->id,
                    ];
                }),
            ];
        });

        return view('contents.page.user-setting', ['modules' => $formattedModules]);
    }

    public function forgotPasswordView()
    {
        return view('auth.forgot-password');
    }

    public function resetPasswordView(Request $request)
    {
        $token = $request->query('token');
        if (! $token) {
            return redirect('/')->with('error', 'Invalid token.');
        }
        return view('auth.reset-password', ['token' => $token]);
    }

    public function targetView()
    {
        if (! auth()->user()->haveAccess('Target', 'read')) {
            abort(403);
        }
        $companies = $this->getCompanies();
        return view('contents.page.target', ['companies' => $companies]);
    }

    public function groupView()
    {
        if (! auth()->user()->haveAccess('Group', 'read')) {
            abort(403);
        }
        $companies = $this->getCompanies();
        return view('contents.page.group', ['companies' => $companies]);

    }

    public function landingPageView()
    {
        if (! auth()->user()->haveAccess('Landing Page', 'read')) {
            abort(403);
        }
        return view('contents.page.landing-page');
    }

    public function emailTemplatesView()
    {
        if (! auth()->user()->haveAccess('Email Template', 'read')) {
            abort(403);
        }
        $companies = $this->getCompanies();
        return view('contents.page.email-templates', ['companies' => $companies]);
    }

    public function sendingProfileView()
    {
        if (! auth()->user()->haveAccess('Sending Profile', 'read')) {
            abort(403);
        }
        $companies = $this->getCompanies();
        return view('contents.page.sending-profiles', ['companies' => $companies]);
    }

    public function campaignView()
    {
        if (! auth()->user()->haveAccess('Campaign', 'read')) {
            abort(403);
        }
        $companies = $this->getCompanies();
        return view('contents.page.campaign', ['companies' => $companies]);
    }

    public function campaignDetailsView($id)
    {
        if (! auth()->user()->haveAccess('Campaign', 'read')) {
            abort(403);
        }
        $check = auth()->user()->accessibleCampaign()->where('campaign_id', $id)->first();
        if (! $check) {
            abort(404);
        }
        return view('contents.page.campaign-details', ['id' => $id]);
    }

    public function adminUserView()
    {
        if (! auth()->user()->is_admin) {
            abort(403);
        }
        $companies = $this->getCompanies();
        if (Gate::allows('IsAdmin')) {
            return view('contents.admin.admin-user', ['companies' => $companies]);
        }
    }

    public function approvalView()
    {
        if (Gate::allows('HaveAccessApproval')) {
            return view('contents.page.approval');
        }
    }

    public function adminCompanyView()
    {
        if (! auth()->user()->is_admin) {
            abort(403);
        }
        $companies = $this->getCompanies();
        if (Gate::allows('IsAdmin')) {
            return view('contents.admin.admin-company', ['companies' => $companies]);
        }
    }

    public function adminGetuserbycompaniesid()
    {
        if (! auth()->user()->is_admin) {
            abort(403);
        }
        $companies = $this->getUser();
        Log::info('Companies:', ['companies' => $companies]);
        if (Gate::allows('IsAdmin')) {
            return view('contents.modal.admin.update-company-admin', ['companies' => $companies]);
        }
    }

    public function employeeDashboardView()
    {
        if (auth()->user()->employee) {
            return view('contents.page.course.employee-dashboard');
        }
    }

    public function courseListsView()
    {
        if (auth()->user()->employee) {
            return view('contents.page.course.course-list');
        }
    }

    public function AdminCourseView()
    {
        if (auth()->user()->is_admin) {
            return view('contents.admin.admin-course');
        }
    }

    public function createCourseView()
    {
        if (auth()->user()->is_admin) {
            return view('contents.admin.create-course');
        }
    }

    public function editCourseView($id)
    {
        if (auth()->user()->is_admin) {
            return view('contents.admin.edit-course', ['id' => $id]);
        }
    }

}
