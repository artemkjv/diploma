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
        Schema::create('news_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('styles')
                ->nullable();
            $table->foreignIdFor(\App\Models\NewsCategory::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignIdFor(\App\Models\User::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Page::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
        Schema::dropIfExists('news_categories');
    }
};
