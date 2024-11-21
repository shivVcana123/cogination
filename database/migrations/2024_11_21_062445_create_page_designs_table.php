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
        Schema::create('page_designs', function (Blueprint $table) {
            $table->id();
            $table->text('title_style')->nullable();
            $table->text('subtitle_style')->nullable();
            $table->text('description_style')->nullable();
            $table->text('button_content_style')->nullable();
            $table->string('header_color')->nullable();
            $table->string('header_image')->nullable();
            $table->string('footer_color')->nullable();
            $table->string('footer_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_designs');
    }
};
