<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class VideoConferenceLog extends Model
{
    use HasFactory, HasHashid, HashidRouting;

    protected $guarded = ['id'];
    protected $appends = ['hashid'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function videoConference()
    {
        return $this->belongsTo(VideoConference::class);
    }

}
