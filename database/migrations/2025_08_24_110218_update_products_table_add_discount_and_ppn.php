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
        Schema::table('products', function (Blueprint $table) {
            $table->enum('discount_type', ['percent', 'amount'])
                ->default('percent')
                ->after('stock');
            $table->decimal('discount_percent', 15, 2)
                ->default(0.00)
                ->after('discount_type');
            $table->decimal('discount_amount', 15, 2)
                ->default(0.00)
                ->after('discount_percent');

            $table->enum('tax_type', ['percent', 'amount'])
                ->default('percent')
                ->after('discount_amount');
            $table->decimal('tax_percent', 15, 2)
                ->default(0.00)
                ->after('tax_type');
            $table->decimal('tax_amount', 15, 2)
                ->default(0.00)
                ->after('tax_percent');

            $table->dropColumn(['discount', 'is_ppn', 'ppn_nominal']);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('discount', 5, 2)->default(0.00);
            $table->tinyInteger('is_ppn')->default(0);
            $table->decimal('ppn_nominal', 15, 2)->default(0.00);

            $table->dropColumn('discount_type');
            $table->dropColumn('discount_percent');
            $table->dropColumn('discount_amount');
            $table->dropColumn('tax_type');
            $table->dropColumn('tax_percent');
            $table->dropColumn('tax_amount');
        });
    }
};
