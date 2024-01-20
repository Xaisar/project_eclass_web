<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class StudentClass extends Model
{
    use HasFactory, HasHashid, HashidRouting;
    protected $guarded = [];

    public function classGroup()
    {
        return $this->belongsTo(ClassGroup::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
