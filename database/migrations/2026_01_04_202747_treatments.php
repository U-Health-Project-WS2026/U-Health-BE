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
            $table->id('treatment_id');
            $table->unsignedBigInteger('user_id');
            $table->text('diagnosis');
            $table->string('type_of_treatment');
            $table->datetimes('date_of_treatment');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('user_id')->on('users')
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
