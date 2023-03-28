<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public function companyprofile()
    {
        return $this->hasOne(CompanyProfile::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function roles() {
        return $this->hasOne(Role::class);
    }
}
