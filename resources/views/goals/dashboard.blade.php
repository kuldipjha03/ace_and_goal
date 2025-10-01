@extends('layouts.header')
@section('title', 'Set Goals')
<body class="bg-light">
    <!-- Sidebar -->
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="px-3">Menu</h4>
        <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
            Dashboard
        </a>
        <a href="{{ route('goals.setgoals') }}" class="{{ request()->routeIs('goals.setgoals') ? 'active' : '' }}">
            ACE & Goal
        </a>
    </div>
    <!-- Main Content -->
    <div class="content">
        <div class="container">
            <a href="{{ route('goals.setgoals') }}" class="btn btn-primary">ACE & Goal</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>