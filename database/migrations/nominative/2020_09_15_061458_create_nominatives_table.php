<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNominativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nominatives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('serial')->index();
            $table->string('number')->index();
            $table->date('tmt')->nullable();
            $table->unsignedBigInteger('teacher_id')->index();
            $table->unsignedBigInteger('school_id')->index();
            $table->string('subject')->nullable();
            $table->string('shorturl')->unique();
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('nominatives');
    }
}
