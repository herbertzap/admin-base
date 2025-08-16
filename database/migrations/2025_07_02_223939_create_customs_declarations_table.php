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
        Schema::create('customs_declarations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Usuario que creó la declaración
            $table->string('declaration_number')->unique();
            $table->string('document_type'); // Tipo de documento (DUS, DUA, etc.)
            $table->string('status')->default('draft'); // draft, submitted, approved, rejected
            $table->date('declaration_date');
            $table->string('customs_office');
            $table->string('transport_mode'); // marítimo, aéreo, terrestre
            $table->string('container_number')->nullable();
            $table->string('bill_of_lading')->nullable();
            $table->decimal('total_value', 15, 2);
            $table->decimal('total_weight', 10, 2);
            $table->text('description');
            $table->json('hermes_message')->nullable(); // Mensaje enviado a Hermes
            $table->json('hermes_response')->nullable(); // Respuesta de Hermes
            $table->timestamp('sent_to_hermes_at')->nullable();
            $table->timestamp('hermes_processed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customs_declarations');
    }
};
