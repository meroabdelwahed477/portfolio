<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('title_ar');
            $table->string('title_en')->nullable();
            $table->text('description_ar');
            $table->text('description_en')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('location_ar')->nullable();
            $table->string('location_en')->nullable();
            $table->string('experience_ar')->nullable();
            $table->string('experience_en')->nullable();
            $table->string('availability_ar')->nullable();
            $table->string('availability_en')->nullable();
            $table->string('photo')->nullable();
            $table->string('cv_file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
