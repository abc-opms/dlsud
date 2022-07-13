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
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('inventory_id');
            $table->string('location');
            $table->string('property_number');
            $table->string('item_description');
            $table->string('serial_number');
            $table->string('fea_number');
            $table->string('acq_date');
            $table->string('qty');
            $table->string('unit_cost');
            $table->string('amount');
            $table->string('old_custodian');
            $table->string('new_custodian');
            $table->string('subdept_code');
            $table->string('dept_code');
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
        Schema::dropIfExists('inventory_items');
    }
};
