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
    <div class="container">
        <form action="{{ route('goals.set') }}" method="POST">
            @csrf

            <!-- Month Picker -->
            <div class="mb-3 position-relative">
                <input type="hidden" name="goal_date" id="goal_date" required>
                <button type="button" class="btn btn-outline-primary" id="monthButton" onclick="openMonthPicker()">Select Month</button>

                <!-- Popup -->
                <div id="monthPicker" class="month-picker shadow position-absolute" style="display:none; top:100%; left:0; z-index:1000;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong id="yearLabel"></strong>
                        <div>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changeYear(-1)">&#8592;</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changeYear(1)">&#8594;</button>
                            <button type="button" class="btn-close ms-2" onclick="closeMonthPicker()"></button>
                        </div>
                    </div>
                    <div class="months d-grid" style="grid-template-columns: repeat(3, 1fr); gap:10px; margin:10px 0;">
                        @foreach(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] as $i => $month)
                            <div class="month" data-val="{{ sprintf('%02d', $i+1) }}">{{ $month }}</div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-primary w-100" onclick="applyMonth()">Apply</button>
                </div>
            </div>

            <!-- Department Dropdown -->
            <div class="mb-3">
                <label>Department</label>
                <select name="department" id="department" class="form-select" required>
                    <option value="">Select Department</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept }}">{{ $dept }}</option>
                    @endforeach
                </select>
            </div>

            <!-- KPIs Table -->
            <div class="mb-3">
                <label>Select KPI(s) & Set Targets</label>
                <table class="table table-bordered">
                    <thead class="table-secondary">
                        <tr>
                            <th>Select</th>
                            <th>KPI</th>
                            <th>Target Type</th>
                            <th>Current Month Target</th>
                            <th>Previous Month Target</th>
                            <th>Second Last Month Target</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $kpisList = [
                                "Create test plans based on project requirements",
                                "Write test cases (manual or automated)",
                                "Review test cases with developers/product team",
                                "Update test scenarios for changed requirement"
                            ];
                        @endphp

                        @foreach($kpisList as $index => $kpiName)
                        <tr>
                            <td>
                                <input type="checkbox" name="kpis[{{ $index }}][selected]" value="1" onchange="toggleRow(this)">
                            </td>
                            <td>
                                <input type="hidden" name="kpis[{{ $index }}][name]" value="{{ $kpiName }}">
                                {{ $kpiName }}
                            </td>
                            <td>
                                <select name="kpis[{{ $index }}][target_type]" class="form-select" disabled>
                                    <option value="Number">Number</option>
                                    <option value="Currency">Currency</option>
                                    <option value="Done/Not done">Done/Not done</option>
                                </select>
                            </td>
                            <td><input type="text" name="kpis[{{ $index }}][target]" class="form-control" placeholder="Enter target" disabled></td>
                            <td><input type="text" class="form-control" disabled></td>
                            <td><input type="text" class="form-control" disabled></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-primary">Send Goal</button>
        </form>
    </div>
</div>

<script>
    let selectedMonth = null;
    let selectedYear = new Date().getFullYear();
    document.getElementById("yearLabel").innerText = selectedYear;

    function openMonthPicker() { document.getElementById("monthPicker").style.display = "block"; }
    function closeMonthPicker() { document.getElementById("monthPicker").style.display = "none"; }
    function changeYear(step) { selectedYear += step; document.getElementById("yearLabel").innerText = selectedYear; }

    // Month selection
    document.querySelectorAll(".month").forEach(month => {
        month.addEventListener("click", () => {
            document.querySelectorAll(".month").forEach(m => m.classList.remove("active"));
            month.classList.add("active");
            selectedMonth = month.getAttribute("data-val");
        });
    });

    function applyMonth() {
        if (!selectedMonth) { alert("Please select a month!"); return; }
        let dateValue = `${selectedYear}-${selectedMonth}-01`;
        document.getElementById("goal_date").value = dateValue;
        document.getElementById("monthButton").innerText = `${document.querySelector(".month.active").innerText} ${selectedYear}`;
        closeMonthPicker();
    }

    // Enable/disable KPI row inputs
    function toggleRow(checkbox) {
        let row = checkbox.closest("tr");
        let selects = row.querySelectorAll("select, input[type=text]");
        selects.forEach(el => el.disabled = !checkbox.checked);
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
