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
        Schema::create('banner_sections', function (Blueprint $table) {
            $table->id();
            $table->string('heading')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('type')->nullable();
            $table->string('section_type')->nullable();
            $table->text('description')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->string('image')->nullable();
            $table->string('page')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_sections');
    }
};
