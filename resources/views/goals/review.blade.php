@extends('layouts.header')
@section('title', 'KPI Review')

<body class="bg-light">

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="px-3">Menu</h4>
    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Dashboard</a>
    <a href="{{ route('goals.setgoals') }}" class="{{ request()->is('goals/*/review') ? 'active' : '' }}">ACE & Goal</a>
</div>

<!-- Main Content -->
<div class="content">
    <div class="container mt-3">

        <h2 class="fw-bold mb-4">KPIs Selection & Employee Distribution</h2>

        <!-- KPI Selection Table -->
        <div class="mb-4">
            <table class="table table-bordered table-hover text-center">
                <thead class="table-secondary">
                    <tr>
                        <th>Select</th>
                        <th>KPI Name</th>
                        <th>Target Type</th>
                        <th>Current Month Target</th>
                        <th>Previous Month Target</th>
                        <th>Second Last Month Target</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($goal->kpis as $kpi)
                        @php
                            $isSelected = $kpi->employees->sum('allocated_target') > 0;
                        @endphp
                        <tr class="{{ $isSelected ? 'table-success' : '' }}">
                            <td>
                                <input type="checkbox" 
                                       name="kpis[{{ $kpi->id }}][selected]" 
                                       value="1" 
                                       {{ $isSelected ? 'checked' : '' }}
                                       onchange="toggleRow(this)">
                            </td>
                            <td class="text-start fw-bold">{{ $kpi->kpi_name }}</td>
                            <td>{{ $kpi->target_type }}</td>
                            <td>{{ $kpi->target ?? '-' }}</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Employee Distribution Table -->
        <div class="table-responsive">
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
                    @foreach($goal->kpis as $kpi)
                        <tr>
                            <td class="text-start fw-bold">{{ $kpi->kpi_name }}</td>
                            @foreach($kpi->employees as $allocation)
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        <input type="number"
                                               class="form-control form-control-sm text-center"
                                               value="{{ $allocation->allocated_target }}"
                                               min="0"
                                               {{ $allocation->is_locked ? '' : 'readonly' }}>
                                        @if($allocation->is_locked)
                                            <i class="bi bi-lock-fill text-danger ms-1" title="Locked"></i>
                                        @endif
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
    // Highlight selected KPI rows in green
    function toggleRow(checkbox) {
        let row = checkbox.closest("tr");
        row.classList.toggle("table-success", checkbox.checked);
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
