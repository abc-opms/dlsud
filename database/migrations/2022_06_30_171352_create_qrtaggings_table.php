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
        Schema::create('qrtaggings', function (Blueprint $table) {
            $table->id();
            $table->string('rqr_number');
            $table->string('property_number');
            $table->string('reason')->nullable();
            $table->string('reqby')->nullable();
            $table->date('req_date')->nullable();
            $table->string('sub_dept')->nullable();
            $table->date('generated_date')->nullable();
            $table->string('generatedby')->nullable();
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
        Schema::dropIfExists('qrtaggings');
    }
};
