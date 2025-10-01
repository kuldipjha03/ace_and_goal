@extends('layouts.header')

@section('title', 'Set Goals')

<div class="container">
    <h2>Set Goals</h2>
    <form action="{{ route('goals.set') }}" method="POST">
        @csrf

        <!-- Month Picker -->
        <div class="mb-3 position-relative">
            <input type="hidden" name="goal_date" id="goal_date" required>
            <button type="button" class="btn btn-outline-primary" id="monthButton"
                onclick="openMonthPicker()">Select Month</button>

            <!-- Popup -->
            <div id="monthPicker" class="month-picker shadow position-absolute"
                style="display:none; top:100%; left:0; z-index:1000;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong id="yearLabel"></strong>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            onclick="changeYear(-1)">&#8592;</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            onclick="changeYear(1)">&#8594;</button>
                        <button type="button" class="btn-close ms-2" onclick="closeMonthPicker()"></button>
                    </div>
                </div>
                <div class="months d-grid"
                    style="grid-template-columns: repeat(3, 1fr); gap:10px; margin:10px 0;">
                    <div class="month" data-val="01">January</div>
                    <div class="month" data-val="02">February</div>
                    <div class="month" data-val="03">March</div>
                    <div class="month" data-val="04">April</div>
                    <div class="month" data-val="05">May</div>
                    <div class="month" data-val="06">June</div>
                    <div class="month" data-val="07">July</div>
                    <div class="month" data-val="08">August</div>
                    <div class="month" data-val="09">September</div>
                    <div class="month" data-val="10">October</div>
                    <div class="month" data-val="11">November</div>
                    <div class="month" data-val="12">December</div>
                </div>
                <button type="button" class="btn btn-primary w-100" onclick="applyMonth()">Apply</button>
            </div>
        </div>

        <!-- Department as Dropdown Buttons -->
        <div class="mb-3">
            <label>Department</label>
            <input type="hidden" name="department" id="department" required>
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    id="deptButton">
                    Select Department
                </button>
                <div class="dropdown-menu dept-menu">
                    @foreach($departments as $dept)
                    <button type="button" class="dept-btn" onclick="selectDepartment('{{ $dept }}', this)">
                        {{ $dept }}
                    </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- KPIs -->
        <div class="mb-3">
            <label>Select KPI(s) & Set Targets</label>
            <table class="table table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th>Select</th>
                        <th>KPI</th>
                        <th>Target Type</th>
                        <th>Current Month Target</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox" onchange="toggleRow(this)"></td>
                        <td>
                            <input type="hidden" name="kpis[0][name]" value="Create test plans based on project requirements">
                            Create test plans based on project requirements
                        </td>
                        <td>
                            <select name="kpis[0][target_type]" class="form-select" disabled>
                                <option value="Number">Number</option>
                                <option value="Currency">Currency</option>
                                <option value="Done/Not done">Done/Not done</option>
                            </select>
                        </td>
                        <td><input type="text" name="kpis[0][target]" class="form-control" placeholder="Enter target" disabled></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" onchange="toggleRow(this)"></td>
                        <td>
                            <input type="hidden" name="kpis[1][name]" value="Write test cases (manual or automated)">
                            Write test cases (manual or automated)
                        </td>
                        <td>
                            <select name="kpis[1][target_type]" class="form-select" disabled>
                                <option value="Number">Number</option>
                                <option value="Currency">Currency</option>
                                <option value="Done/Not done">Done/Not done</option>
                            </select>
                        </td>
                        <td><input type="text" name="kpis[1][target]" class="form-control" placeholder="Enter target" disabled></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>

    <hr>
    <h3>All Goals</h3>
    <table class="table table-bordered">
        <tr>
            <th>Date</th>
            <th>Department</th>
            <th>KPIs</th>
        </tr>
        @foreach($goals as $goal)
        <tr>
            <td>{{ $goal->goal_date }}</td>
            <td>{{ $goal->department }}</td>
            <td>
                @foreach($goal->kpis as $kpi)
                {{ $kpi->kpi_name }} ({{ $kpi->target }})<br>
                @endforeach
            </td>
        </tr>
        @endforeach
    </table>
</div>

@include('layouts.footer')
