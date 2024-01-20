<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachingMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teaching_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('core_competence_id');
            $table->unsignedBigInteger('basic_competence_id');
            $table->enum('type', ['file', 'image', 'video', 'audio', 'youtube', 'article']);
            $table->string('attachment');
            $table->string('name');
            $table->tinyText('description')->nullable();
            $table->boolean('is_share')->default(false);
            $table->timestamps();
            $table->foreign('course_id')->references('id')->on('courses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('core_competence_id')->references('id')->on('core_competences')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('basic_competence_id')->references('id')->on('basic_competences')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teaching_materials');
    }
}
