<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('treatments_medications', function (Blueprint $table) {
            $table->unsignedBigInteger('treatment_id');
            $table->unsignedBigInteger('medication_id');
            $table->integer('dosis');
            $table->integer('amount');
            $table->timestamps();

            $table->primary(['treatment_id', 'medication_id']);

            $table->foreign('treatment_id')
                ->references('treatment_id')->on('treatments')
                ->onDelete('cascade');

            $table->foreign('medication_id')
                ->references('medication_id')->on('medications')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatments_medications');
    }
};
