<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up(): void
    {
        Schema::create('treatments_diseases', function (Blueprint $table) {
            $table->unsignedBigInteger('treatment_id');
            $table->unsignedBigInteger('disease_id');
            $table->timestamps();

            $table->primary(['treatment_id', 'disease_id']);

            $table->foreign('treatment_id')
                ->references('treatment_id')->on('treatments');

            $table->foreign('disease_id')
                ->references('disease_id')->on('diseases');
        });

    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('treatments_diseases');
    }
};
