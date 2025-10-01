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
        Schema::create('goal_kpis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goal_id')->constrained('goals')->onDelete('cascade');
            
            // KPI details
            $table->string('kpi_name');
            $table->integer('target'); // better as integer instead of string
            $table->string('target_type'); // Number, Currency, Done/Not done

            // Distribution status
            $table->boolean('is_locked')->default(false); // Lock target toggle
            
            $table->timestamps();
        });

        // Schema::create('goal_kpi_distributions', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('goal_kpi_id')->constrained('goal_kpis')->onDelete('cascade');
        //     $table->foreignId('employee_id')->constrained('users')->onDelete('cascade'); 
        //     $table->integer('assigned_target'); // target assigned to employee
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('goal_kpi_distributions');
        Schema::dropIfExists('goal_kpis');
    }
};
