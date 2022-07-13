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
        Schema::create('rritems', function (Blueprint $table) {
            $table->id();
            $table->string('department_id');
            $table->string('acc_code');
            $table->string('item_description');
            $table->string('oum');
            $table->float('unit_cost');
            $table->float('order_qty');
            $table->float('deliver_qty');
            $table->float('amount');
            $table->string('rr_number');
            $table->string('receivedby')->nullable();
            $table->date('received_date')->nullable();
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
        Schema::dropIfExists('rritems');
    }
};
