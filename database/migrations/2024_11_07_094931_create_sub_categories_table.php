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
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id(); // UnsignedBigInteger
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->unsignedBigInteger('categories_id')->nullable(); // Ensure unsignedBigInteger for foreign key
            $table->enum('status', ['1', '0'])->default('1')->comment('1 = active, 0 = inactive');
            $table->timestamps();

            // Foreign key relationship
            $table->foreign('categories_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('set null'); // Allow setting null if category is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_categories');
    }
};
