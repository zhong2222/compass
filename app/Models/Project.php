<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',   
        'image',
        'company_id',
        'category_id',
    ];

    // テスト時companyの代わりにuserを一時使用
    public function user() {
        return $this->belongsTo(User::class);
    }

    // public function company() {
    //     return $this->belongsTo(Company::class);
    // }

    // public function category() {
    //     return $this->belongsTo(Category::class);
    // }
    
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
