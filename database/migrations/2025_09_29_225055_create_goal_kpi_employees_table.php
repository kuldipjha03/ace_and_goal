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
        Schema::create('goal_kpi_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goal_kpi_id')->constrained('goal_kpis')->onDelete('cascade');
            $table->string('employee_name');
            $table->integer('allocated_target')->default(0);
            $table->boolean('is_locked')->default(false);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goal_kpi_employees');
    }
};
