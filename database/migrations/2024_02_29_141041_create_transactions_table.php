<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('date')->default(now());
            $table->string('description')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('category');
            $table->enum('type', ['income', 'expense']);
            $table->string('transfer_type')->nullable(); 
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
