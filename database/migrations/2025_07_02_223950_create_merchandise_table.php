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
        Schema::create('merchandise', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customs_declaration_id')->constrained()->onDelete('cascade');
            $table->string('item_number');
            $table->string('description');
            $table->string('hs_code'); // Código arancelario
            $table->string('origin_country');
            $table->decimal('quantity', 10, 2);
            $table->string('unit_of_measure');
            $table->decimal('unit_value', 15, 2);
            $table->decimal('total_value', 15, 2);
            $table->decimal('weight', 10, 2);
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->text('additional_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchandise');
    }
};
