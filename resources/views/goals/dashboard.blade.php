<!DOCTYPE html>
<html>
<head>
    <title>Distribute KPI Targets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        /* Sidebar styles */
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
            margin-bottom: 5px;
        }

        .sidebar a:hover {
            background: #495057;
        }

        .sidebar a.active {
            background: #0d6efd;
            font-weight: bold;
            border-left: 4px solid #ffc107;
        }

        /* Content area */
        .content {
            margin-left: 230px;
            padding: 20px;
        }

        /* KPI table */
        .kpi-table th, .kpi-table td {
            text-align: center;
            vertical-align: middle;
        }

        .lock-icon {
            color: #0d6efd;
            font-size: 16px;
            cursor: pointer;
        }

        .lock-icon.locked {
            color: #6c757d;
        }

        input[type=number] {
            width: 80px;
            text-align: center;
        }

        .role-label {
            display: block;
            font-size: 12px;
            color: #6c757d;
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
        <a href="{{ route('goals.setgoals') }}" class="{{ request()->routeIs('goals.setgoals') ? 'active' : '' }}">
            ACE & Goal
        </a>
    </div>
</body>
</html>
