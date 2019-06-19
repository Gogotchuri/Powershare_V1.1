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
    private const MAX_NUMBER_OF_VIDEOS = 6;
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

    /**
     * Returns filled surveys by user
     */
    public function filledSurveys(){
        return $this->hasMany(FilledSurvey::class);
    }

    public function savedCampaigns(){
        return $this->hasMany(SavedCampaign::class);
    }

    public function watchedVideos(){
        return $this->hasMany(WatchedVideo::class, "user_id", "id");
    }
    /**
     * Returns watched videos by user, which has been watched today
     */
    public function getWatchedVideosToday(){
        $watched_videos = $this->watchedVideos;
        $watched_videos_today = $watched_videos->filter(function ($v){
            return self::watchedVideoFilter($v);
        });

        return $watched_videos_today;
    }

    /**
     * Takes Watched Video object as an @parameter and returns true if it has been watched
     * less than a day ago
     * @param $v watchedVideo
     * @return bool
     * @throws Exception
     */
    private static function watchedVideoFilter($v){
        $today = new DateTime(date("d-m-Y H:i:s"));
        $submission_date = new DateTime(date_format(date_create($v->created_at), "d-m-Y H:i:s"));
        $dateDiff = date_diff($submission_date, $today);
        $day_diff = $dateDiff->format("%d");
        return $day_diff < "1";
    }

    /**
     * Returns true if user has filled more than allowed surveys today
     */
    public function exceedsWatchLimit(){
        return $this->getWatchedVideosToday()->count() >= self::MAX_NUMBER_OF_VIDEOS;
    }

    /**
     * Returns number of videos left before limit for today
     * For the user
     */
    public function numBeforeWatchLimit(){
        return self::MAX_NUMBER_OF_VIDEOS - $this->getWatchedVideosToday()->count();
    }

}
