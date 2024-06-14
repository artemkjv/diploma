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

        Schema::create('client_request_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color');
            $table->timestamps();
        });

        Schema::create('client_requests', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('theme');
            $table->text('content');
            $table->foreignIdFor(\App\Models\ClientRequestStatus::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_requests');
        Schema::dropIfExists('client_request_statuses');
    }
};
