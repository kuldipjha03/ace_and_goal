<!DOCTYPE html>
<html>

<head>
    <title>Goals Module</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .sidebar {
            height: 100vh;
            width: 220px;
            position: fixed;
            top: 0;
            left: 0;
            background: #343a40;
            color: white;
            padding-top: 20px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #495057;
        }

        .content {
            margin-left: 230px;
            padding: 20px;
        }

        .sidebar a.active {
            background: #0d6efd;
            font-weight: bold;
            border-left: 4px solid #ffc107;
        }

        /* Month Picker Styles */
        .month-picker {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 260px;
        }

        .month {
            padding: 6px;
            text-align: center;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .month:hover {
            background: #f0f0f0;
        }

        .month.active {
            background: #0d6efd;
            color: white;
            font-weight: bold;
        }

        /* Department button styles */
        .dropdown-menu.dept-menu {
            padding: 10px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            min-width: 500px;
        }

        .dept-btn {
            border: 1px solid #0d6efd;
            background: white;
            color: #0d6efd;
            font-size: 14px;
            padding: 6px 10px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.2s;
            text-align: center;
            width: 100%;
        }

        .dept-btn:hover {
            background: #e9f2ff;
        }

        .dept-btn.active {
            background: #0d6efd;
            color: white;
            font-weight: bold;
            border: none;
        }
    </style>
</head>

<body class="bg-light">
    <!-- Sidebar -->
<body class="bg-light">
    <!-- Sidebar -->
       <div class="sidebar">
        <h4 class="px-3">Menu</h4>
        <a href="#">Dashboard</a>
        <a href="{{ route('goals.setgoals') }}" class="{{ request()->routeIs('goals.distribute') ? 'active' : '' }}">
            ACE & Goal
        </a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container">
      

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
