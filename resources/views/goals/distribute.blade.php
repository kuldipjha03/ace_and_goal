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
       <div class="sidebar">
        <h4 class="px-3">Menu</h4>
        <a href="#">Dashboard</a>
        <a href="{{ route('goals.setgoals') }}" class="{{ request()->routeIs('goals.distribute') ? 'active' : '' }}">
            ACE & Goal
        </a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container mt-3">

            <h5 class="mb-4">Role : {{ $goal->department }} - {{ \Carbon\Carbon::parse($goal->goal_date)->format('m/Y') }}</h5>

            <form id="distributionForm" method="POST" action="{{ route('goals.distribute.save',$goal->id) }}">
                @csrf

                <div class="table-responsive">
                    <table class="table table-bordered kpi-table">
                        <thead class="table-light">
                            <tr>
                                <th>KPI Name</th>
                                @foreach($employees as $emp)
                                    <th>
                                        {{ $emp['name'] }}
                                        <span class="role-label">{{ $emp['role'] }}</span>
                                        <input type="hidden" name="employees[]" value="{{ $emp['name'] }}">
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($goal->kpis as $kpi)
                                <tr>
                                    <td>{{ $kpi->kpi_name }}</td>
                                    @foreach($employees as $emp)
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <input type="number"
                                                    name="targets[{{ $emp['name'] }}][{{ $kpi->id }}]"
                                                    class="form-control form-control-sm"
                                                    min="0"
                                                    value="0">
                                                <i class="bi bi-lock-fill lock-icon" onclick="toggleLock(this)"></i>
                                                <input type="hidden"
                                                    name="lock[{{ $emp['name'] }}][{{ $kpi->id }}]"
                                                    value="0">
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary">Save & Create Ticket</button>
                </div>
            </form>
        </div>
    </div>

<script>
function toggleLock(icon){
    let input = icon.closest("td").querySelector("input[type=number]");
    let hidden = icon.closest("td").querySelector("input[type=hidden]");

    if(icon.classList.contains("locked")){
        // Unlock
        icon.classList.remove("locked");
        icon.classList.remove("bi-lock");
        icon.classList.add("bi-lock-fill");
        input.removeAttribute("readonly");
        hidden.value = 0;
    } else {
        // Lock
        icon.classList.add("locked");
        icon.classList.remove("bi-lock-fill");
        icon.classList.add("bi-lock");
        input.setAttribute("readonly", true);
        hidden.value = 1;
    }
}

document.getElementById("distributionForm").addEventListener("submit", function(e){
    e.preventDefault();
    let form = this;
    fetch(form.action,{
        method:"POST",
        body:new FormData(form),
        headers:{"X-CSRF-TOKEN":"{{ csrf_token() }}"}
    }).then(res=>res.json()).then(data=>{
        if(data.status==='success'){
            Swal.fire({
                title:data.message,
                icon:'success',
                confirmButtonText:'OK'
            }).then(()=>{window.location.href="{{ route('goals.all') }}";});
        }
    });
});
</script>
</body>
</html>
