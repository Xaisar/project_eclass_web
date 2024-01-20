<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Major extends Model
{
    use HasFactory, HasHashid, HashidRouting;
    protected $guarded = [];

    public function classGroup()
    {
        return $this->hasMany(ClassGroup::class);
    }

    public function subject()
    {
        return $this->hasMany(Subject::class);
    }
    public function student()
    {
        return $this->hasMany(Student::class);
    }
}
