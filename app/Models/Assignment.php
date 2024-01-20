<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Assignment extends Model
{
    use HasFactory, HasHashid, HashidRouting;

    protected $guarded = [];
    protected $appends = ['hashid'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function knowledge_assessment()
    {
        return $this->hasMany(KnowledgeAssessment::class);
    }

    public function skill_assessment()
    {
        return $this->hasMany(SkillAssessment::class);
    }

    public function assignmentAttachment()
    {
        return $this->hasMany(AssignmentAttachment::class);
    }

    public function assignmentDetail()
    {
        return $this->hasMany(AssignmentDetail::class);
    }
}
