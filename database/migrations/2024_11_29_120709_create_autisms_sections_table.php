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
        Schema::create('autisms_sections', function (Blueprint $table) {
            $table->id();
            $table->string('first_title')->nullable();
            $table->string('type')->nullable();
            $table->text('first_subtitle')->nullable();
            $table->text('first_description')->nullable();
            $table->string('first_button_content')->nullable();
            $table->string('first_button_link')->nullable();
            $table->string('first_image')->nullable();
            $table->string('second_title')->nullable();
            $table->text('second_subtitle')->nullable();
            $table->text('second_description')->nullable();
            $table->string('second_button_content')->nullable();
            $table->string('second_button_link')->nullable();
            $table->string('second_image')->nullable();
            $table->json('pointers')->nullable();
            $table->string('page')->nullable();
            $table->string('url')->nullable();
            $table->enum('status', ['on', 'off'])->default('on')->comment('on = show, off = hide');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autisms_sections');
    }
};
