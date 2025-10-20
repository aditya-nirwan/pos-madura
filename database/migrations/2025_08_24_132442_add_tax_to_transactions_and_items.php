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
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('total_tax', 15, 2)->default(0)->after('total_discount');
        });

        Schema::table('transaction_items', function (Blueprint $table) {
            $table->decimal('tax_amount', 15, 2)->default(0)->after('discount_amount');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('total_tax');
        });

        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropColumn('tax_amount');
        });
    }
};