<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = ['goal_date', 'department'];

    public function kpis()
    {
        return $this->hasMany(GoalKpi::class);
    }
}
