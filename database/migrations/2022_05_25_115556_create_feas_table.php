<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feas', function (Blueprint $table) {
            $table->id();
            $table->string('fea_number')->unique();
            $table->string('rr_number')->unique();

            $table->unsignedBigInteger('checkedby')->nullable();
            $table->date('checked_date')->nullable();

            $table->unsignedBigInteger('notedby')->nullable();
            $table->date('noted_date')->nullable();

            $table->unsignedBigInteger('recordedby')->nullable();
            $table->date('recorded_date')->nullable();

            $table->unsignedBigInteger('receivedby')->nullable();
            $table->date('received_date')->nullable();

            $table->unsignedBigInteger('rnotedby')->nullable();
            $table->date('rnoted_date')->nullable();
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
        Schema::dropIfExists('feas');
    }
};
