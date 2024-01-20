<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_group_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('study_year_id');
            $table->string('thumbnail')->nullable()->default('default-course.png');
            $table->integer('semester');
            $table->integer('number_of_meetings')->default(0);
            $table->tinyText('description')->nullable();
            $table->enum('status', ['open', 'close']);
            $table->timestamps();
            $table->foreign('class_group_id')->references('id')->on('class_groups')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('subject_id')->references('id')->on('subjects')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('courses');
    }
}
