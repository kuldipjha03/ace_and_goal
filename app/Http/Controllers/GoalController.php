<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goal;
use App\Models\GoalKpi;
use App\Models\GoalKpiEmployee;

class GoalController extends Controller
{

    public function dashboard()
    {
        $departments = ['L1-Marketing', 'L2-Sales', 'L3-Operations', 'L4-IT', 'L5-HR'];
        $kpis = ['Revenue Growth', 'Customer Acquisition', 'Lead Conversion Rate', 'Client Retention', 'Team Productivity', 'Training Hours'];
        $goals = Goal::with('kpis.employees')->latest()->get();

        return view('goals.dashboard', compact('departments', 'kpis', 'goals'));
    }

    public function index()
    {
        $departments = ['L1-Marketing', 'L2-Sales', 'L3-Operations', 'L4-IT', 'L5-HR'];
        $kpis = ['Revenue Growth', 'Customer Acquisition', 'Lead Conversion Rate', 'Client Retention', 'Team Productivity', 'Training Hours'];
        $goals = Goal::with('kpis.employees')->latest()->get();

        return view('goals.index', compact('departments', 'kpis', 'goals'));
    }

    public function allGoals()
    {
        // Eager load KPIs and employees
        $goals = Goal::with('kpis.employees')->latest()->get();

        return view('goals.all', compact('goals'));
    }


    //   public function setGoal(Request $request)
    // {
    //     $request->validate([
    //         'goal_date' => 'required|date',
    //         'department' => 'required|string',
    //         'kpis' => 'required|array|min:1'
    //     ]);

    //     $goal = Goal::create([
    //         'goal_date' => $request->goal_date,
    //         'department' => $request->department
    //     ]);

    //     foreach ($request->kpis as $kpi) {
    //         // only save if checkbox is checked
    //         if (!empty($kpi['name'])) {
    //             GoalKpi::create([
    //                 'goal_id'     => $goal->id,
    //                 'kpi_name'    => $kpi['name'],
    //                 'target'      => $kpi['target'] ?? 0,
    //                 'target_type' => $kpi['target_type'] ?? 'Number'
    //             ]);
    //         }
    //     }

    //     return redirect()->route('goals.distribute', $goal->id)
    //                      ->with('success', 'Targets saved successfully.');
    // }


    public function setGoal(Request $request)
    {
        $request->validate([
            'goal_date' => 'required|date',
            'department' => 'required|string',
            'kpis' => 'required|array|min:1'
        ]);

        $goal = Goal::create([
            'goal_date' => $request->goal_date,
            'department' => $request->department
        ]);

        foreach ($request->kpis as $kpi) {
            // only insert if checkbox is selected
            if (!empty($kpi['selected'])) {
                GoalKpi::create([
                    'goal_id'     => $goal->id,
                    'kpi_name'    => $kpi['name'],
                    'target'      => $kpi['target'] ?? 0,
                    'target_type' => $kpi['target_type'] ?? 'Number'
                ]);
            }
        }

        return redirect()->route('goals.distribute', $goal->id)
            ->with('success', 'Targets saved successfully.');
    }




    public function distribute($goalId)
    {
        $goal = Goal::with('kpis')->findOrFail($goalId);
        $employees = [
            ['name' => 'Shreharsh Maradwar', 'role' => 'Primary'],
            ['name' => 'Deven Dullarwar', 'role' => 'Primary'],
            ['name' => 'Shivam Prajapati', 'role' => 'Ancillary'],
            ['name' => 'Pratik Bhutale', 'role' => 'Ancillary'],
        ];
        return view('goals.distribute', compact('goal', 'employees'));
    }



    public function saveDistribution(Request $request, $goalId)
    {
        $request->validate([
            'employees' => 'required|array',
            'targets' => 'required|array'
        ]);

        foreach ($request->employees as $emp) {
            foreach ($request->targets[$emp] as $kpiId => $value) {
                GoalKpiEmployee::updateOrCreate(
                    ['goal_kpi_id' => $kpiId, 'employee_name' => $emp],
                    ['allocated_target' => $value, 'is_locked' => $request->lock[$emp][$kpiId] ?? false]
                );
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'KPI tasks created successfully',
             'goal_id'  => $goalId  // 🔥 return the id
        ]);
    }

    public function review($goalId)
    {
        // Fetch goal with KPIs and employees distribution
        $goal = Goal::with(['kpis.employees'])->findOrFail($goalId);

        return view('goals.review', compact('goal'));
    }
}
