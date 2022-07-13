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
        Schema::create('tempitems', function (Blueprint $table) {
            $table->id();
            $table->string('item');
            $table->string('dept_code');
            $table->string('acc_code');
            $table->string('oum');
            $table->float('unit_cost');
            $table->float('order_qty');
            $table->float('deliver_qty');
            $table->float('amount');
            $table->string('school_id');
            $table->string('receivedby');
            $table->string('addItemRR')->nullable();
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
        Schema::dropIfExists('tempitems');
    }
};
