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
        Schema::create('our_approach_how_it_works', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->json('pointers')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('our_approach_how_it_works');
    }
};
