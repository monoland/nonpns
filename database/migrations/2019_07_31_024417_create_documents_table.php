<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->string('hash')->unique();
            $table->string('extn');
            $table->string('type');
            $table->string('mime');
            $table->string('path');
            $table->unsignedInteger('byte')->default(0);
            $table->string('furl')->nullable();
            $table->string('kind')->nullable();
            $table->string('kind_numb')->nullable();
            $table->date('kind_date')->nullable();
            $table->string('kind_sign')->nullable();
            $table->unsignedSmallInteger('vers')->default(1);
            $table->boolean('actv')->default(true);
            $table->unsignedBigInteger('user_id')->index();
            $table->nullableMorphs('documentable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
