<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Shift extends Model
{
    use HasFactory, HasHashid, HashidRouting;
    protected $guarded = [];
    protected $appends = ['hashid'];

    public function studentClass()
    {
        return $this->hasMany(StudentClass::class);
    }
}
