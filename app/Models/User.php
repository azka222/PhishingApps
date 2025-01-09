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
            'password' => 'hashed',
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

    // public function accessible($module)
    // {
    //     $admin = $this->adminCheck();
    //     if ($admin) {

    //     } else {

    //     }
    //     switch ($module) {
    //         case 'Target':
    //             return Target::with('department', 'position')->where('company_id', auth()->user()->company_id);
    //         case 'Group':
    //             return Group::with('department', 'target.department', 'target.position')->where('company_id', auth()->user()->company_id);
    //         case 'SendingProfile':
    //             return SendingProfileCompany::where('company_id', auth()->user()->company_id);
    //         case 'EmailTemplate':
    //             return EmailTemplateCompany::where('company_id', auth()->user()->company_id);
    //         case 'Campaign':
    //             return CompanyCampaign::where('company_id', auth()->user()->company_id);
    //         default:
    //             break;
    //     }
    // }

    public function accessibleTarget()
    {
        $admin = $this->adminCheck();
        if ($admin) {
            return Target::with('department', 'position');
        } else {
            return Target::with('department', 'position')->where('company_id', auth()->user()->company_id);
        }
    }

    public function accessibleGroup()
    {
        $admin = $this->adminCheck();
        if ($admin) {
            return Group::with('department', 'target.department', 'target.position');
        } else {
            return Group::with('department', 'target.department', 'target.position')->where('company_id', auth()->user()->company_id);
        }
    }

    public function accessibleEmailTemplate()
    {
        $admin = $this->adminCheck();
        if ($admin) {
            return EmailTemplateCompany::with('company');
        } else {
            return EmailTemplateCompany::with('company')->where('company_id', auth()->user()->company_id);
        }
    }

    public function accessibleSendingProfile()
    {
        $admin = $this->adminCheck();
        if ($admin) {
            return SendingProfileCompany::with('company');
        } else {
            return SendingProfileCompany::with('company')->where('company_id', auth()->user()->company_id);
        }
    }

    public function accessibleCampaign()
    {
        $admin = $this->adminCheck();
        if ($admin) {
            return CompanyCampaign::with('company');
        } else {
            return CompanyCampaign::with('company')->where('company_id', auth()->user()->company_id);
        }
    }

    public static function adminCheck()
    {
        return auth()->user()->is_admin;
    }

}
