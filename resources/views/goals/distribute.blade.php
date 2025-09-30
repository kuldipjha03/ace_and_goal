<!DOCTYPE html>
<html>
<head>
    <title>Distribute KPI Targets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
<h3>Distribute KPI Targets for {{ $goal->department }} ({{ $goal->goal_date }})</h3>

<form id="distributionForm" method="POST" action="{{ route('goals.distribute.save',$goal->id) }}">
    @csrf
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Employee</th>
                @foreach($goal->kpis as $kpi)
                    <th>{{ $kpi->kpi_name }} (Target: {{ $kpi->target }})</th>
                    <th>Lock</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $emp)
            <tr>
                <td>{{ $emp }}<input type="hidden" name="employees[]" value="{{ $emp }}"></td>
                @foreach($goal->kpis as $kpi)
                    <td>
                        <input type="number" name="targets[{{ $emp }}][{{ $kpi->id }}]" class="form-control" min="0">
                    </td>
                    <td>
                        <input type="checkbox" name="lock[{{ $emp }}][{{ $kpi->id }}]" value="1">
                    </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
    <button type="submit" class="btn btn-success">Save & Create Ticket</button>
</form>
</div>

<script>
document.getElementById("distributionForm").addEventListener("submit",function(e){
    e.preventDefault();
    let form=this;
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
            }).then(()=>{window.location.href="{{ route('goals.index') }}";});
        }
    });
});
</script>
</body>
</html>
