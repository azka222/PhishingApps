<?php
namespace App\Models;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmailContract
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use Notifiable, MustVerifyEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'phone',
        'company_id',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public static function getProfileDetails()
    {
        return User::with('company')->find(auth()->user()->id);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public static function adminCheck()
    {
        return auth()->user()->is_admin;
    }

    public function companyAdmin($id)
    {
        if ($this->adminCheck()) {
            return true;
        }
        $checkRole = Role::where('company_id', $id)->where('company_admin', 1)->first();
        if ($checkRole->id === $this->role_id) {
            return true;
        } else {
            return false;
        }

    }

    public function getModule($module)
    {
        return Module::where('name', $module)->first();
    }

    public function getAbility($ability)
    {
        return Ability::where('name', $ability)->first();
    }

    // Access
    public function haveAccess($module, $ability)
    {
        if ($this->adminCheck()) {
            return true;
        }
        $role              = $this->role;
        $module            = $this->getModule($module);
        $ability           = $this->getAbility($ability);
        $moduleAbility     = ModuleAbility::where('module_id', $module->id)->where('ability_id', $ability->id)->first();
        $roleModuleAbility = RoleModuleAbilities::where('role_id', $role->id)->where('module_abilities_id', $moduleAbility->id)->first();
        if ($roleModuleAbility) {
            return true;
        }

        return false;
    }

    public function canAccessDashboard()
    {
        return $this->haveAccess('Dashboard', 'read');
    }

    public function canAccessTargetGroup()
    {
        return $this->haveAccess('Target', 'read') || $this->haveAccess('Group', 'read');
    }

    public function canAccessAttribute()
    {
        return $this->haveAccess('Sending Profile', 'read') || $this->haveAccess('Landing Page', 'read') || $this->haveAccess('Email Template', 'read');
    }

    public function canCreateTarget()
    {
        return $this->haveAccess('Target', 'create');
    }

    public function accessibleTarget()
    {
        if ($this->haveAccess('Target', 'read') && ! $this->adminCheck()) {
            return Target::with('department', 'position')->where('company_id', $this->company_id);
        } else if ($this->adminCheck()) {
            return Target::with('department', 'position');
        }
    }

    public function canUpdateTarget()
    {
        return $this->haveAccess('Target', 'update');
    }

    public function canDeleteTarget()
    {
        return $this->haveAccess('Target', 'delete');
    }

    public function canModifyTarget()
    {
        return $this->canUpdateTarget() || $this->canDeleteTarget();
    }

    public function canCreateGroup()
    {
        return $this->haveAccess('Group', 'create') && ! $this->adminCheck();
    }

    public function accessibleGroup()
    {
        if ($this->haveAccess('Group', 'read') && ! $this->adminCheck()) {
            return Group::with('target.position', 'target.department')->where('company_id', $this->company_id)->get();

        } else if ($this->adminCheck()) {
            return Group::with('target.position', 'target.department');
        }
    }

    public function canModifyGroup()
    {
        return $this->canUpdateGroup() || $this->canDeleteGroup();
    }



    public function canUpdateGroup()
    {
        return $this->haveAccess('Group', 'update');
    }

    public function canDeleteGroup()
    {
        return $this->haveAccess('Group', 'delete');
    }

    public function canCreateSendingProfile()
    {
        return $this->haveAccess('Sending Profile', 'create');
    }

    public function canUpdateSendingProfile()
    {
        return $this->haveAccess('Sending Profile', 'update');
    }

    public function canDeleteSendingProfile()
    {
        return $this->haveAccess('Sending Profile', 'delete');
    }

    public function canModifySendingProfile()
    {
        return $this->canUpdateSendingProfile() || $this->canDeleteSendingProfile();
    }

    public function accessibleSendingProfile()
    {
        if ($this->haveAccess('Sending Profile', 'read') && ! $this->adminCheck()) {
            return SendingProfileCompany::where('company_id', $this->company_id);
        } else if ($this->adminCheck()) {
            return SendingProfileCompany::query();
        }
    }

    public function canCreateLandingPage()
    {
        return $this->haveAccess('Landing Page', 'create');
    }

    public function canUpdateLandingPage()
    {
        return $this->haveAccess('Landing Page', 'update');
    }

    public function canDeleteLandingPage()
    {
        return $this->haveAccess('Landing Page', 'delete');
    }

    public function canModifyLandingPage()
    {
        return $this->canUpdateLandingPage() || $this->canDeleteLandingPage();
    }

    public function accessibleLandingPage()
    {
        if ($this->haveAccess('Landing Page', 'read') && ! $this->adminCheck()) {
            return LandingPageCompany::where('company_id', $this->company_id);
        } else if ($this->adminCheck()) {
            return LandingPageCompany::query();
        }
    }

    public function canCreateEmailTemplate()
    {
        return $this->haveAccess('Email Template', 'create');
    }

    public function canUpdateEmailTemplate()
    {
        return $this->haveAccess('Email Template', 'update');
    }

    public function canDeleteEmailTemplate()
    {
        return $this->haveAccess('Email Template', 'delete');
    }

    public function canModifyEmailTemplate()
    {
        return $this->canUpdateEmailTemplate() || $this->canDeleteEmailTemplate();
    }

    public function accessibleEmailTemplate()
    {
        if ($this->haveAccess('Email Template', 'read') && ! $this->adminCheck()) {
            return EmailTemplateCompany::where('company_id', $this->company_id);
        } else if ($this->adminCheck()) {
            return EmailTemplateCompany::query();
        }
    }

    public function canCreateCampaign()
    {
        return $this->haveAccess('Campaign', 'create') && ! $this->adminCheck();
    }

    public function canDeleteCampaign()
    {
        return $this->haveAccess('Campaign', 'delete');
    }

    public function accessibleCampaign()
    {
        if ($this->haveAccess('Campaign', 'read') && ! $this->adminCheck()) {
            return CompanyCampaign::where('company_id', $this->company_id);
        } else if ($this->adminCheck()) {
            return CompanyCampaign::query();
        }
    }

    public function isCompanyOwner($id)
    {
        if ($this->adminCheck()) {
            return true;
        }
        $company = Company::where('id', $id)->first();
        if ($company->user_id === $this->id) {
            return true;
        } else {
            return false;
        }
    }

    public function haveAccessApproval()
    {
        return $this->companyAdmin($this->company_id) && $this->isCompanyOwner($this->company_id);
    }

}
