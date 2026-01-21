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
        Schema::create('treatments_diseases', function (Blueprint $table) {
            $table->unsignedBigInteger('treatment_id');
            $table->unsignedBigInteger('disease_id');
            $table->timestamps();

            $table->primary(['treatment_id', 'disease_id']);

            $table->foreign('treatment_id')
                ->references('treatment_id')->on('treatments')
                ->onDelete('cascade');

            $table->foreign('disease_id')
                ->references('disease_id')->on('diseases')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatments_diseases');
    }
};
