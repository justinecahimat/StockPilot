<style>

     :root {
            --sidebar-bg: #111e2e;
            --sidebar-hover: #1c2d42;
            --sidebar-active: #1f3d45;
            --sidebar-active-border: #107c57;
            --primary-green: #107c57;
            --primary-green-hover: #0c6144;
            --light-bg: #f4f6f8;
            --chart-bar-light: #b4d8c6;
        }

        body {
            background-color: var(--light-bg);
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
        }

    /* SIDEBAR */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;

        width: 260px;
        height: 100vh;

        overflow-y: auto;
        overflow-x: hidden;
    }

    /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            min-height: 100vh;
            color: #92a4b8;
        }

        .sidebar .brand-title {
            color: #ffffff;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .sidebar .brand-subtitle {
            font-size: 0.65rem;
            letter-spacing: 1px;
            color: #6c7d93;
        }

        .sidebar .section-label {
            font-size: 0.7rem;
            letter-spacing: 0.8px;
            color: #58697d;
            font-weight: 600;
        }

        .sidebar .nav-link {
            color: #8c9ba8;
            border-radius: 8px;
            padding: 9px 14px;
            font-size: 0.875rem;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: #ffffff;
        }

        .sidebar .nav-link.active {
            background-color: var(--sidebar-active);
            color: #ffffff;
            font-weight: 500;
            border-left: 3px solid var(--sidebar-active-border);
        }
</style>


<aside class="sidebar p-3 d-flex flex-column">

    <div class="mb-4 ps-2 pt-2">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-box-seam-fill text-success fs-4"></i>
            <div>
                <div class="brand-title">StockPilot</div>
                <div class="brand-subtitle">
                    RESTAURANT INVENTORY SYSTEM
                </div>
            </div>
        </div>
    </div>

    <div class="section-label mb-2 ps-2">WORKSPACE</div>

    <nav class="nav flex-column mb-auto">

        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>

        <a href="{{ route('ingredients.index') }}"
           class="nav-link {{ request()->routeIs('ingredients.*') ? 'active' : '' }}">
            <i class="bi bi-box"></i> Ingredients & Supplies
        </a>

        <a href="{{ route('categories.index') }}"
           class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Categories
        </a>

        <a href="{{ route('suppliers.index') }}"
           class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
            <i class="bi bi-truck"></i> Suppliers
        </a>

        <a href="{{ route('stock-in.create') }}"
           class="nav-link {{ request()->routeIs('stock-in.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-down-left-square"></i> Stock-In
        </a>

        <a href="{{ route('stock-out.create') }}"
           class="nav-link {{ request()->routeIs('stock-out.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-up-right-square"></i> Stock-Out
        </a>

        <hr class="border-secondary my-2">

        <a href="{{ route('low-stock-alert') }}" 
            class="nav-link {{ request()->routeIs('low-stock-alert*') ? 'active' : '' }}">
            <i class="bi bi-exclamation-triangle"></i> Low-Stock Alerts
        </a>

        <a href="{{ route('purchase-request') }}" 
            class="nav-link {{ request()->routeIs('purchase-request*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i> Purchase Requests
        </a>

        <a href="{{ route('inventory.history') }}" 
            class="nav-link {{ request()->routeIs('inventory.history*') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i> Inventory History
        </a>

        <a href="{{ route('reports.index') }}" 
            class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart"></i> Reports
        </a>

        <a href="{{ route('users.index') }}" 
            class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> User Management
        </a>

    </nav>

    <div class="mt-3 pt-3 border-top border-secondary">
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <a href="#"
               onclick="this.closest('form').submit(); return false;"
               class="nav-link text-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </form>
    </div>

</aside>