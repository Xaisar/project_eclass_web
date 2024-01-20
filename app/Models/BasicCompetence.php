<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class BasicCompetence extends Model
{
    use HasFactory, HasHashid, HashidRouting;

    protected $guarded = [];
    protected $appends = ['hashid'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function coreCompetence()
    {
        return $this->belongsTo(CoreCompetence::class);
    }

    public function teachingMaterial()
    {
        return $this->hasMany(TeachingMaterial::class);
    }

    public function assignmentDetail()
    {
        return $this->hasMany(AssignmentDetail::class);
    }
}
