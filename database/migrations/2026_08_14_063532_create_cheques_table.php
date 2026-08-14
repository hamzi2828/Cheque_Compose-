<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cheques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bank_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bank_cheque_sequence_id')->nullable()
                  ->constrained('bank_cheque_sequences')->nullOnDelete();
            $table->unsignedBigInteger('cheque_number');
            $table->date('cheque_date');
            $table->string('memo')->nullable();
            $table->decimal('amount', 12, 2);
            $table->timestamps();

            $table->unique(['bank_id', 'cheque_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cheques');
    }
};
