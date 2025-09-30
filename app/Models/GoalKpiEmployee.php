<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoalKpiEmployee extends Model
{
    protected $fillable = ['goal_kpi_id','employee_name','allocated_target','is_locked'];

    public function kpi()
    {
        return $this->belongsTo(GoalKpi::class, 'goal_kpi_id');
    }
}

