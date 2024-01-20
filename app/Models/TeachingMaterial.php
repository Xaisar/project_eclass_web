<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class TeachingMaterial extends Model
{
    use HasFactory, HasHashid, HashidRouting;

    protected $guarded = ['id'];
    protected $appends = ['hashid'];

    public function coreCompetence()
    {
        return $this->belongsTo(CoreCompetence::class);
    }

    public function basicCompetence()
    {
        return $this->belongsTo(BasicCompetence::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
