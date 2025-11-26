<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
            $table->string('title_en')->nullable();
            $table->text('description_ar');
            $table->text('description_en')->nullable();
            $table->enum('category', ['web', 'api-web', 'api-mobile']);
            $table->string('thumbnail')->nullable();
            $table->string('link')->nullable();
            $table->text('features_ar')->nullable(); // JSON array
            $table->text('features_en')->nullable(); // JSON array
            $table->text('technologies')->nullable(); // JSON array
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
