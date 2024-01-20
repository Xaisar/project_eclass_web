<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class VideoConference extends Model
{
    use HasFactory, HasHashid, HashidRouting;

    protected $guarded = ['id'];
    protected $appends = ['hashid'];

    public function videoConferenceLog()
    {
        return $this->hasMany(VideoConferenceLog::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
