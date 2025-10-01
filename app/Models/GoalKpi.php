<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoalKpi extends Model
{
    protected $fillable = ['goal_id','kpi_name','target','target_type'];

    public function employees()
    {
        return $this->hasMany(GoalKpiEmployee::class);
    }

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
}
