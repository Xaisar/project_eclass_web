<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasicCompetencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basic_competences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('core_competence_id');
            $table->unsignedBigInteger('course_id');
            $table->integer('code');
            $table->integer('semester');
            $table->tinyText('name');
            $table->timestamps();
            $table->foreign('core_competence_id')->references('id')->on('core_competences')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('course_id')->references('id')->on('courses')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('basic_competences');
    }
}
