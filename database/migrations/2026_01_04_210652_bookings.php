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
        Schema::create('bookings', function (Blueprint $table): void
        {

            $table->id("booking_id");
            $table->unsignedBigInteger("admin_id");
            $table->unsignedBigInteger("patient_id");
            $table->dateTime("time_slot_start");
            $table->dateTime("time_slot_end");
            $table->tinyInteger("status");
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
        Schema::dropIfExists('bookings');
    }
};
