<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('degree_id');
            $table->unsignedBigInteger('major_id');
            $table->string('code')->unique();
            $table->string('name');
            $table->boolean('status')->default(true);
            $table->foreign('degree_id')->references('id')->on('degrees')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('major_id')->references('id')->on('majors')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_groups');
    }
}
