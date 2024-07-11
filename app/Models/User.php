<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use App\Models\Permission;

//for email verification , MustVerifyEmail
// use Illuminate\Auth\Events\Registered;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    protected $connection = "mysql";
    protected $table = "user_employee_credentials";
    protected $primaryKey = "id";
    protected $rememberTokenName = false;
    protected $guarded = [
        'id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = bcrypt($value);
    // }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatars')
            ->singleFile();
    }

    public function userEmployee()
    {
        return $this->hasOne(UserEmployees::class, 'empl_id', 'username');
    }

    public function employeeSpecialDepartment()
    {
        return $this->hasOne(EmployeeSpecialDepartment::class, 'employee_code', 'username');
    }
    // public function User()
    // {
    //     return $this->hasOne(UserEmployeeCredential::class, 'e')
    // }
    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = bcrypt($value);
    // }
    //,'user_id','permission_id'
    // public function permissions()
    // {
    //     return $this->belongsToMany(Permission::class, 'permission_user')->withPivot('permission_id');
    // }

    //for email verification
    // public function verifyUserEmail($value)
    // {
    //     event(new Registered($value));
    // }
}
