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
            $table->bigIncrements('id');
            $table->string('nik')->nullable()->index();
            $table->string('front_title')->nullable();
            $table->string('name')->index();
            $table->string('back_title')->nullable();
            $table->enum('gender', ['L', 'P'])->index()->default('L');
            $table->string('born_place')->nullable()->index();
            $table->date('born_date')->nullable()->index();
            $table->enum('status', ['Pendidik', 'Tenaga Kependidikan'])->index()->default('Pendidik');
            $table->date('tmt')->nullable()->index();
            $table->enum('merried', ['kawin', 'blm_kawin', 'duda', 'janda'])->nullable()->index();
            $table->enum('source', ['APBN', 'APBD', 'LAINNYA'])->nullable()->index();
            $table->unsignedBigInteger('education_id')->nullable()->index();
            $table->string('register')->nullable()->index();
            $table->unsignedBigInteger('school_id')->index();
            $table->unsignedBigInteger('branch_id')->index();
            $table->unsignedBigInteger('city_id')->index();
            $table->timestamps();
        });

        Schema::create('subject_teacher', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subject_id')->index();
            $table->unsignedBigInteger('teacher_id')->index();
            $table->boolean('mandatory')->default(false);
            $table->boolean('harmony')->default(false);
        });

        Schema::create('school_teacher', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('school_id')->index();
            $table->unsignedBigInteger('teacher_id')->index();
            $table->boolean('mandatory')->default(false);
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
        Schema::dropIfExists('subject_teacher');
        Schema::dropIfExists('school_teacher');
    }
}
