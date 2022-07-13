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
        Schema::create('item_disposals', function (Blueprint $table) {
            $table->id();
            $table->string('rdf_number')->unique();
            $table->string('from');
            $table->date('date');
            $table->string('subdept_code');
            $table->string('reason');

            $table->string('endorsedto');
            $table->date('endorsed_date')->nullable();

            $table->string('checkedby')->nullable();
            $table->date('checked_date')->nullable();

            $table->string('approvedby')->nullable();
            $table->date('approved_date')->nullable();

            $table->string('evaluatedby')->nullable();
            $table->date('evaluated_date')->nullable();

            $table->string('notedby')->nullable();
            $table->date('noted_date')->nullable();

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
        Schema::dropIfExists('item_disposals');
    }
};
