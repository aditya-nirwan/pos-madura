<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_ppn')->default(false)->after('discount');
            $table->decimal('ppn_nominal', 15, 2)->default(0)->after('is_ppn');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_ppn', 'ppn_nominal']);
        });
    }
};
