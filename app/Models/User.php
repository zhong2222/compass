<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\NewVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'icon',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userprofile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // テスト時companyの代わりにuserを一時使用
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }
    
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    // 新しいメール通知文を使う
    public function sendEmailVerificationNotification(){
        $this->notify(new NewVerifyEmail());
    }
    
}
