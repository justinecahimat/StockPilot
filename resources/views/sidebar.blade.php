
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

        <a href="#" class="nav-link">
            <i class="bi bi-exclamation-triangle"></i> Low-Stock Alerts
        </a>

        <a href="#" class="nav-link">
            <i class="bi bi-file-earmark-text"></i> Purchase Requests
        </a>

        <a href="#" class="nav-link">
            <i class="bi bi-clock-history"></i> Inventory History
        </a>

        <a href="#" class="nav-link">
            <i class="bi bi-bar-chart"></i> Reports
        </a>

        <a href="#" class="nav-link">
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
