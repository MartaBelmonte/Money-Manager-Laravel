<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
{
    Schema::create('transaction_details', function (Blueprint $table) {
        $table->id();
        $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
        $table->string('item_name');
        $table->decimal('unit_price', 10, 2);
        $table->integer('quantity');
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
