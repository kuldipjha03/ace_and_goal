<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goal;
use App\Models\GoalKpi;
use App\Models\GoalKpiEmployee;

class GoalController extends Controller
{
    public function index()
    {
        $departments = ['L1-Marketing','L2-Sales','L3-Operations','L4-IT','L5-HR'];
        $kpis = ['Revenue Growth','Customer Acquisition','Lead Conversion Rate','Client Retention','Team Productivity','Training Hours'];
        $goals = Goal::with('kpis.employees')->latest()->get();

        return view('goals.index', compact('departments','kpis','goals'));
    }

    public function setGoal(Request $request)
    {
        $request->validate([
            'goal_date'=>'required|date',
            'department'=>'required|string',
            'kpis'=>'required|array|min:1',
            'targets'=>'required|array'
        ]);

        $goal = Goal::create([
            'goal_date'=>$request->goal_date,
            'department'=>$request->department
        ]);

        foreach($request->kpis as $kpi){
            GoalKpi::create([
                'goal_id'=>$goal->id,
                'kpi_name'=>$kpi,
                'target'=>$request->targets[$kpi] ?? ''
            ]);
        }

        return redirect()->route('goals.distribute', $goal->id)->with('success','Targets saved successfully.');
    }

    public function distribute($goalId)
    {
        $goal = Goal::with('kpis')->findOrFail($goalId);
        $employees = ['Alice','Bob','Charlie','David']; // example employee list
        return view('goals.distribute', compact('goal','employees'));
    }

    public function saveDistribution(Request $request, $goalId)
    {
        $request->validate([
            'employees'=>'required|array',
            'targets'=>'required|array'
        ]);

        foreach($request->employees as $emp){
            foreach($request->targets[$emp] as $kpiId=>$value){
                GoalKpiEmployee::updateOrCreate(
                    ['goal_kpi_id'=>$kpiId,'employee_name'=>$emp],
                    ['allocated_target'=>$value,'is_locked'=>$request->lock[$emp][$kpiId] ?? false]
                );
            }
        }

        return response()->json([
            'status'=>'success',
            'message'=>'KPI tasks created successfully'
        ]);
    }
}
