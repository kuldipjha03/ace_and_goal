@extends('layouts.header')
@section('title', 'Set Goals')
<body class="bg-light">
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="px-3">Menu</h4>
        <a href="#">Dashboard</a>
        <a href="{{ route('goals.setgoals') }}" class="{{ request()->routeIs('goals.setgoals') ? 'active' : '' }}">
            ACE & Goal
        </a>
    </div>
    <!-- Main Content -->
    <div class="content">
        <div class="container">

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
                            <div class="month" data-val="01">Jan</div>
                            <div class="month" data-val="02">Feb</div>
                            <div class="month" data-val="03">March</div>
                            <div class="month" data-val="04">April</div>
                            <div class="month" data-val="05">May</div>
                            <div class="month" data-val="06">June</div>
                            <div class="month" data-val="07">July</div>
                            <div class="month" data-val="08">August</div>
                            <div class="month" data-val="09">Sept</div>
                            <div class="month" data-val="10">Oct</div>
                            <div class="month" data-val="11">Nov</div>
                            <div class="month" data-val="12">Dec</div>
                        </div>
                        <button type="button" class="btn btn-primary w-100" onclick="applyMonth()">Apply</button>
                    </div>
                </div>

                <!-- Department as Dropdown Buttons -->
                <!-- Department as Normal Dropdown -->
                <div class="mb-3">
                    <label>Department</label>
                    <select name="department" id="department" class="form-select" required>
                        <option value="">Select Department</option>
                        @foreach($departments as $dept)
                        <option value="{{ $dept }}">{{ $dept }}</option>
                        @endforeach
                    </select>
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
                                <td>
                                    <input type="checkbox" onchange="toggleRow(this)">
                                </td>
                                <td>
                                    <input type="hidden" name="kpis[0][name]"
                                        value="Create test plans based on project requirements">
                                    Create test plans based on project requirements
                                </td>
                                <td>
                                    <select name="kpis[0][target_type]" class="form-select" disabled>
                                        <option value="Number">Number</option>
                                        <option value="Currency">Currency</option>
                                        <option value="Done/Not done">Done/Not done</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="kpis[0][target]" class="form-control"
                                        placeholder="Enter target" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" onchange="toggleRow(this)">
                                </td>
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
                                <td>
                                    <input type="text" name="kpis[1][target]" class="form-control"
                                        placeholder="Enter target" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" onchange="toggleRow(this)">
                                </td>
                                <td>
                                    <input type="hidden" name="kpis[2][name]" value="Review test cases with developers/product team">
                                    Review test cases with developers/product team
                                </td>
                                <td>
                                    <select name="kpis[2][target_type]" class="form-select" disabled>
                                        <option value="Number">Number</option>
                                        <option value="Currency">Currency</option>
                                        <option value="Done/Not done">Done/Not done</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="kpis[2][target]" class="form-control"
                                        placeholder="Enter target" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" onchange="toggleRow(this)">
                                </td>
                                <td>
                                    <input type="hidden" name="kpis[3][name]" value="Update test scenarios for changed requirement">
                                    Update test scenarios for changed requirement
                                </td>
                                <td>
                                    <select name="kpis[3][target_type]" class="form-select" disabled>
                                        <option value="Number">Number</option>
                                        <option value="Currency">Currency</option>
                                        <option value="Done/Not done">Done/Not done</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="kpis[3][target]" class="form-control"
                                        placeholder="Enter target" disabled>
                                </td>
                            </tr>
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

        function openMonthPicker() {
            document.getElementById("monthPicker").style.display = "block";
        }

        function closeMonthPicker() {
            document.getElementById("monthPicker").style.display = "none";
        }

        function changeYear(step) {
            selectedYear += step;
            document.getElementById("yearLabel").innerText = selectedYear;
        }

        // Month selection
        document.querySelectorAll(".month").forEach(month => {
            month.addEventListener("click", () => {
                document.querySelectorAll(".month").forEach(m => m.classList.remove("active"));
                month.classList.add("active");
                selectedMonth = month.getAttribute("data-val");
            });
        });

        function applyMonth() {
            if (!selectedMonth) {
                alert("Please select a month!");
                return;
            }
            let dateValue = `${selectedYear}-${selectedMonth}-01`;
            document.getElementById("goal_date").value = dateValue;
            document.getElementById("monthButton").innerText =
                `${document.querySelector(".month.active").innerText} ${selectedYear}`;
            closeMonthPicker();
        }

        // Enable/disable KPI row inputs
        function toggleRow(checkbox) {
            let row = checkbox.closest("tr");
            let selects = row.querySelectorAll("select, input[type=text]");
            selects.forEach(el => el.disabled = !checkbox.checked);
        }

        // Select department button
        function selectDepartment(dept, btn) {
            document.getElementById("department").value = dept;
            document.getElementById("deptButton").innerText = dept;
            document.querySelectorAll(".dept-btn").forEach(b => b.classList.remove("active"));
            btn.classList.add("active");
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>