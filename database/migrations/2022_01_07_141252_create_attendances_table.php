<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['course', 'school']);
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('study_year_id');
            $table->integer('semester');
            $table->integer('number_of_meetings')->nullable();
            $table->time('checkin')->nullable();
            $table->time('checkout')->nullable();
            $table->date('date');
            $table->enum('status', ['present', 'permission', 'sick', 'absent', 'late', 'forget', 'holiday']);
            $table->string('description')->nullable();
            $table->timestamps();
            $table->foreign('course_id')->references('id')->on('courses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('study_year_id')->references('id')->on('study_years')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
