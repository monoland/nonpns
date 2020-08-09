<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('school_id');
            $table->enum('status', ['Pendidik', 'Tenaga Kependidikan']);
            $table->unsignedBigInteger('subject_id');
            $table->unsignedSmallInteger('require');
            $table->unsignedSmallInteger('available');
            $table->unsignedSmallInteger('balance');
            $table->timestamps();

            $table->unique(['school_id', 'subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requirements');
    }
}
