<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class HolidaySetting extends Model
{
     use HasFactory, HasHashid, HashidRouting;

     protected $guarded = [];
}
