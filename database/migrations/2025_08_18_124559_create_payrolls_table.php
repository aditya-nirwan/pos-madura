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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();

            $table->integer('addition_salary')->default(0);
            $table->integer('deduction_salary')->default(0);
            $table->integer('gross_salary')->default(0);
            $table->integer('pph_21_tax')->default(0);
            $table->integer('take_home_pay')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
