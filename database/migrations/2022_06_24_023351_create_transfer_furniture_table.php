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
        Schema::create('transfer_furniture', function (Blueprint $table) {
            $table->id();
            $table->string('rtf_number')->unique();
            $table->string('from');
            $table->date('date');
            $table->string('subdept_code');
            $table->string('reason');

            $table->string('receiving_dept');
            $table->string('custodian');
            $table->string('dept_head');

            $table->string('checkedby')->nullable();
            $table->date('checked_date')->nullable();

            $table->string('approvedby')->nullable();
            $table->date('approved_date')->nullable();

            $table->string('postedby')->nullable();
            $table->date('posted_date')->nullable();

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
        Schema::dropIfExists('transfer_furniture');
    }
};
