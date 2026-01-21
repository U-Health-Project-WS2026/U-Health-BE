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
        Schema::create(table: 'treatments', callback: function (Blueprint $table): void
        {
            $table->id("treatment_id");
            $table->unsignedBigInteger("patient_id");
            $table->unsignedBigInteger("admin_id");
            $table->text("diagnosis");
            $table->string("type_of_treatment");
            $table->timestamps();

            $table->foreign('admin_id')
                ->references('admin_id')->on('admins')
                ->onDelete('cascade');

            $table->foreign('patient_id')
                ->references('patient_id')->on('patients')
                ->onDelete('cascade');

        }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatments');
    }
};
