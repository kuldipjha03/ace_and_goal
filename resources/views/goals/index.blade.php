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
    </style>

    <style>
        .sidebar a.active {
            background: #0d6efd;
            /* Bootstrap primary color */
            font-weight: bold;
            border-left: 4px solid #ffc107;
            /* Yellow highlight */
        }
    </style>


    <script>
        function toggleTargetInput(checkbox, kpi) {
            let targetField = document.getElementById('target_' + kpi);
            if (checkbox.checked) {
                targetField.style.display = 'block';
            } else {
                targetField.style.display = 'none';
                targetField.querySelector('input').value = '';
            }
        }
    </script>
</head>

<body class="bg-light">
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="px-3">Menu</h4>
        <a href="#">Dashboard</a>
        <a href="{{ route('goals.index') }}"
            class="{{ request()->routeIs('goals.index') ? 'active' : '' }}">
            ACE & Goal
        </a>
    </div>


    <!-- Main Content -->
    <div class="content">
        <div class="container">
            <h2>Set Goals</h2>
            <form action="{{ route('goals.set') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Date</label>
                    <input type="date" name="goal_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Department</label>
                    <select name="department" class="form-select" required>
                        <option value="">--Select Department--</option>
                        @foreach($departments as $dept)
                        <option value="{{ $dept }}">{{ $dept }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Select KPI(s) & Set Targets</label>
                    <table class="table table-bordered">
                        <thead class="table-secondary">
                            <tr>
                                <th>Select</th>
                                <th>KPI</th>
                                <th>Target Type</th>
                                <th>Current Month Target (05/25)</th>
                                <th>Previous Month Target (04/25)</th>
                                <th>Second Last Month Target (03/25)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox" name="kpis[]" value="Create test plans based on project requirements" onchange="toggleTargetInput(this,'t1')"></td>
                                <td>Create test plans based on project requirements</td>
                                <td> <select name="type[plan]" class="form-select">
                                        <option value="Number">Number</option>
                                        <option value="Currency">Currency</option>
                                        <option value="Done/Not done">Done/Not done</option>
                                    </select></td>
                                <td><input type="text" id="t1" name="targets[plan]" class="form-control" style="display:none;"></td>
                                <td><input type="text" value="10" class="form-control" readonly></td>
                                <td><input type="text" value="0" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="kpis[]" value="Write test cases (manual or automated)" onchange="toggleTargetInput(this,'t2')"></td>
                                <td>Write test cases (manual or automated)</td>
                                <td> <select name="type[plan]" class="form-select">
                                        <option value="Number">Number</option>
                                        <option value="Currency">Currency</option>
                                        <option value="Done/Not done">Done/Not done</option>
                                    </select></td>
                                <td><input type="text" id="t2" name="targets[write_cases]" class="form-control" style="display:none;"></td>
                                <td><input type="text" value="0" class="form-control" readonly></td>
                                <td><input type="text" value="0" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="kpis[]" value="Review test cases with developers/product team" onchange="toggleTargetInput(this,'t3')"></td>
                                <td>Review test cases with developers/product team</td>
                                <td> <select name="type[plan]" class="form-select">
                                        <option value="Number">Number</option>
                                        <option value="Currency">Currency</option>
                                        <option value="Done/Not done">Done/Not done</option>
                                    </select></td>
                                <td><input type="text" id="t3" name="targets[review_cases]" class="form-control" style="display:none;"></td>
                                <td><input type="text" value="0" class="form-control" readonly></td>
                                <td><input type="text" value="0" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="kpis[]" value="Review test cases with developers/product team (duplicate)" onchange="toggleTargetInput(this,'t4')"></td>
                                <td>Review test cases with developers/product team</td>
                                <td> <select name="type[plan]" class="form-select">
                                        <option value="Number">Number</option>
                                        <option value="Currency">Currency</option>
                                        <option value="Done/Not done">Done/Not done</option>
                                    </select></td>
                                <td><input type="text" id="t4" name="targets[review_cases_dup]" class="form-control" style="display:none;"></td>
                                <td><input type="text" value="0" class="form-control" readonly></td>
                                <td><input type="text" value="0" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="kpis[]" value="Update test scenarios for changed requirement" onchange="toggleTargetInput(this,'t5')"></td>
                                <td>Update test scenarios for changed requirement</td>
                                <td> <select name="type[plan]" class="form-select">
                                        <option value="Number">Number</option>
                                        <option value="Currency">Currency</option>
                                        <option value="Done/Not done">Done/Not done</option>
                                    </select></td>
                                <td><input type="text" id="t5" name="targets[update_scenarios]" class="form-control" style="display:none;"></td>
                                <td><input type="text" value="0" class="form-control" readonly></td>
                                <td><input type="text" value="0" class="form-control" readonly></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <button type="submit" class="btn btn-success">Save & Send Goal</button>
            </form>

            <script>
                function toggleTargetInput(checkbox, targetId) {
                    let targetField = document.getElementById(targetId);
                    if (checkbox.checked) {
                        targetField.style.display = 'block';
                    } else {
                        targetField.style.display = 'none';
                        targetField.value = '';
                    }
                }
            </script>


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

</body>

</html>