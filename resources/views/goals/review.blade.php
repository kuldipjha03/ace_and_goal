@extends('layouts.header')
@section('title', 'Set Goals')

<body class="bg-light">

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="px-3">Menu</h4>
    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Dashboard</a>
    <a href="{{ route('goals.setgoals') }}" class="{{ request()->routeIs('goals.setgoals') ? 'active' : '' }}">ACE & Goal</a>
</div>

<!-- Main Content -->
<div class="content">
    <div class="container mt-3">

        <!-- Page Heading -->
        <h2 class="fw-bold mb-4">Set Goals & KPI Distribution</h2>

        <!-- KPI Table -->
        <div class="mb-4">
            <label class="fw-semibold">KPIs Table</label>
            <table class="table table-bordered table-hover text-center">
                <thead class="table-secondary">
                    <tr>
                        <th>KPI Name</th>
                        <th>Target Type</th>
                        <th>Current Month Target</th>
                        <th>Previous Month Target</th>
                        <th>Second Last Month Target</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($goal->kpis as $kpi)
                        <tr>
                            <td class="text-start fw-bold">{{ $kpi->kpi_name }}</td>
                            <td>{{ $kpi->target_type }}</td>
                            <td>{{ $kpi->target ?? '-' }}</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No KPIs found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Employee Distribution Table -->
        <div class="table-responsive">
            <label class="fw-semibold">Distribute KPIs to Employees</label>
            <table class="table table-bordered kpi-table text-center">
                <thead class="table-light">
                    <tr>
                        <th>KPI Name</th>
                        @if($goal->kpis->isNotEmpty())
                            @foreach($goal->kpis->first()->employees as $emp)
                                <th>{{ $emp->employee_name }}</th>
                            @endforeach
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($goal->kpis as $kpi)
                        <tr>
                            <td class="text-start fw-bold">{{ $kpi->kpi_name }}</td>
                            @foreach($kpi->employees as $allocation)
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        <span class="{{ $allocation->is_locked ? 'text-muted' : 'fw-bold' }}">
                                            {{ $allocation->allocated_target }}
                                        </span>
                                        @if($allocation->is_locked)
                                            <i class="bi bi-lock-fill text-danger" title="Locked"></i>
                                        @endif
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 1 + ($goal->kpis->first()->employees->count() ?? 0) }}" class="text-center text-muted">
                                No KPI distribution found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
