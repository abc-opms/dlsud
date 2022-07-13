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
        Schema::create('furniture_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transfer_furniture_id')->nullable();
            $table->float('qty')->nullable();
            $table->string('unit')->nullable();
            $table->string('item_description')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('fea_number')->nullable();
            $table->date('acq_date')->nullable();
            $table->string('property_number');
            $table->string('remarks')->nullable();
            $table->string('evaluatedby')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('furniture_items');
    }
};
