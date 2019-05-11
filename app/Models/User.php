<?php

namespace App\Models;

use App\Notifications\PasswordResetEmail;
use App\Notifications\VerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\References\Role;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *  !!!might need to add provide info
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'author_id');
    }

    public function getIsAdminAttribute()
    {
        return $this->role_id == Role::ADMIN;
    }

    public function ownsCampaign($id)
    {
        return $this->campaigns()->where('id', $id)->count() != 0;
    }

    public function getIsVerifiedAttribute(){
        return $this->email_verified_at !== null;
    }
    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetEmail($token));
    }
    /**Need To implements other relations with comments, team members
     * transactions and donations, as platform grows etc.
     */

}
