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
        Schema::create('patients', function (Blueprint $table): void
        {

            $table->id("patient_id");
            $table->string("name");
            $table->integer("age");
            $table->tinyInteger("sex");
            $table->string("username");
            $table->string("password");
            $table->string("email");
            $table->string("location");
            $table->timestamps();
        }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
