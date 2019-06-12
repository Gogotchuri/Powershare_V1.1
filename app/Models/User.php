<?php

namespace App\Models;

use App\Notifications\PasswordResetEmail;
use App\Notifications\VerifyEmail;
use DateInterval;
use DateTime;
use Exception;
use function foo\func;
use Illuminate\Support\Facades\Date;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\References\Role;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, SoftDeletes;
    private const MAX_NUMBER_OF_SURVEYS = 6;
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
        return $this->campaigns->where('id', $id)->count() != 0;
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


    /**
     * Returns filled surveys by user
     */
    public function filledSurveys(){
        return $this->hasMany(FilledSurvey::class);
    }

    /**
     * Returns filled surveys by user, which has been filled today
     */
    public function getFilledSurveysToday(){
        $filled_surveys = $this->filledSurveys;
        $filled_surveys = $filled_surveys->filter(function($s){
            return $this->filledSurveysFilter($s);
        });

        return $filled_surveys;
    }

    /**
     * Takes $s survey as an @parameter and return if it has been filled
     * less than a day ago
     * @param $s
     * @return bool
     * @throws Exception
     */
    private function filledSurveysFilter($s){
        $oneDayInterval = new DateInterval("P1D");
        $today = new DateTime(date("d-m-Y H:i:s"));
        $submission_date = new DateTime(date_format(date_create($s->created_at), "d-m-Y H:i:s"));
        $dateDiff = date_diff($submission_date, $today);
        return $dateDiff < $oneDayInterval;
    }

    /**
     * Returns true if user has filled more than allowed surveys today
     */
    public function exceedsSurveyLimit(){
        return $this->getFilledSurveysToday()->count() >= self::MAX_NUMBER_OF_SURVEYS;
    }

    /**
     * Returns number of surveys left before limit for today
     * For the user
     */
    public function numBeforeSurveyLimit(){
        return self::MAX_NUMBER_OF_SURVEYS - $this->getFilledSurveysToday()->count();
    }

}
