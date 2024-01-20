<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Student extends Model
{
    use HasApiTokens, HasFactory, HasHashid, HashidRouting, SoftDeletes;
    protected $guarded = [];
    protected $appends = ['hashid'];

    public function studentClass()
    {
        return $this->hasMany(StudentClass::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function studentIncident()
    {
        return $this->hasMany(StudentIncident::class);
    }

    public function semesterAssessment()
    {
        return $this->hasMany(SemesterAssessment::class);
    }

    public function skillAssessment()
    {
        return $this->hasMany(SkillAssessment::class);
    }

    public function knowledgeAssessment()
    {
        return $this->hasMany(KnowledgeAssessment::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
