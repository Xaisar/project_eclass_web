<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class ClassGroup extends Model
{
      use HasFactory, HasHashid, HashidRouting;
      protected $guarded = [];
      protected $appends = ['hashid'];

      public function degree()
      {
            return $this->belongsTo(Degree::class);
      }

      public function major()
      {
            return $this->belongsTo(Major::class);
      }
      public function studentClass()
      {
            return $this->hasMany(StudentClass::class);
      }

      public function course()
      {
            return $this->hasMany(Course::class);
      }
}
