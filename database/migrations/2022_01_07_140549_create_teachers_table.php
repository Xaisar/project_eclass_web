<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('position_id');
            $table->string('identity_number');
            $table->string('name');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('phone_number');
            $table->string('email');
            $table->string('birthplace')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('address');
            $table->year('year_of_entry');
            $table->string('picture')->default('default.png');
            $table->boolean('status')->default(true);
            $table->string('last_education')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teachers');
    }
}
