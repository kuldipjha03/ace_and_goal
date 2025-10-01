<div class="sidebar">
    <h4 class="px-3">Menu</h4>
    <a href="#">Dashboard</a>
    <a href="{{ route('goals.setgoals') }}" 
       class="{{ request()->routeIs('goals.setgoals') ? 'active' : '' }}">
        ACE & Goal
    </a>
</div>

<style>
    .sidebar {
        height: 100vh;
        width: 220px;
        position: fixed;
        top: 0;
        left: 0;
        background: #f8f9fa;
        padding-top: 20px;
        border-right: 1px solid #ddd;
    }
    .sidebar a {
        display: block;
        padding: 10px 15px;
        text-decoration: none;
        color: #333;
    }
    .sidebar a.active {
        background: #0d6efd;
        color: #fff;
        border-radius: 5px;
    }
    .content {
        margin-left: 240px;
        padding: 20px;
    }
</style>
