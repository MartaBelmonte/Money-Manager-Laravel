<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransferTypeToTransactionsTable extends Migration
{
   
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('transfer_type')->nullable()->after('category'); // Agrega la columna 'transfer_type' después de 'category'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('transfer_type'); // Elimina la columna 'transfer_type'
        });
    }
}
