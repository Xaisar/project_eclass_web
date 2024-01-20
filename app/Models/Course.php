<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Course extends Model
{
     use HasFactory, HasHashid, HashidRouting;
     protected $guarded = [];
     protected $appends = ['hashid'];

     public function classGroup()
     {
          return $this->belongsTo(ClassGroup::class);
     }
     public function teacher()
     {
          return $this->belongsTo(Teacher::class);
     }
     public function subject()
     {
          return $this->belongsTo(Subject::class);
     }
     public function studyYear()
     {
          return $this->belongsTo(StudyYear::class);
     }

     public function basicComptence()
     {
          return $this->hasMany(BasicCompetence::class);
     }

     public function studentIncident()
     {
          return $this->hasMany(StudentIncident::class);
     }

     public function teachingMaterial()
     {
          return $this->hasMany(TeachingMaterial::class);
     }

     public function lessonPlan()
     {
          return $this->hasMany(LessonPlan::class);
     }

     public function videoConference()
     {
          return $this->hasMany(VideoConference::class);
     }

     public function attendance()
     {
          return $this->hasMany(Attendance::class);
     }

     public function semesterAssessment()
     {
          return $this->hasMany(SemesterAssessment::class);
     }
     public function assignment()
     {
          return $this->hasMany(Assignment::class);
     }

     public function broadcastLog()
     {
         return $this->hasMany(BroadcastLog::class);
     }
}
