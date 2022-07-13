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
        Schema::create('receivingreports', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_code');
            $table->string('rr_number')->unique();
            $table->date('delivery_date');
            $table->string('ponum');
            $table->string('invoice');
            $table->date('invoice_date')->nullable();
            $table->string('receipt_photo_path');
            $table->float('total');
            $table->string('checkedby')->nullable();
            $table->date('checked_date')->nullable();
            $table->string('preparedby')->nullable();
            $table->date('prepared_date')->nullable();
            $table->string('fea_number');
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
        Schema::dropIfExists('receivingreports');
    }
};
