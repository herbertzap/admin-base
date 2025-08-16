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
        Schema::create('api_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customs_declaration_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('endpoint');
            $table->string('method'); // GET, POST, PUT, DELETE
            $table->json('request_data')->nullable();
            $table->json('response_data')->nullable();
            $table->integer('response_code')->nullable();
            $table->string('status'); // success, error, pending
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at');
            $table->timestamp('received_at')->nullable();
            $table->integer('response_time_ms')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_logs');
    }
};
