<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockPilot - Low-Stock Alerts</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --light-bg: #f8fafc;
            --primary-green: #146c43;
            --primary-green-hover: #0f5132;
        }

        body {
            background-color: var(--light-bg);
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            color: #1e293b;
        }

        .low-stock-layout {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        .main-content.low-stock-page {
            flex: 1;
            margin-left: 260px;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 0;
            background-color: var(--light-bg);
            box-sizing: border-box;
        }

        /* Prevent sizing inconsistencies */
        .low-stock-page *,
        .low-stock-page *::before,
        .low-stock-page *::after {
            box-sizing: border-box;
        }

        /* Top Navbar */
        .top-navbar {
            height: 72px;
            min-height: 72px;
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .top-nav {
            font-size: 0.85rem;
            color: #6c757d;
        }

        /* Search Box */
        .search-box {
            width: 220px;
            height: 36px;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 12px;
            border: 1px solid #dbe3ed;
            border-radius: 7px;
            background: #f8fafc;
        }

        .search-box i {
            font-size: 12px;
            color: #64748b;
        }

        .search-box input {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            font-size: 12px;
            color: #1e293b;
        }

        /* Page Content Padding */
        .low-stock-content {
            padding: 24px 32px;
        }

        /* Buttons */
        .btn-green {
            background-color: var(--primary-green);
            color: white;
            font-weight: 500;
        }

        .btn-green:hover {
            background-color: var(--primary-green-hover);
            color: white;
        }

        /* Summary Cards (Matching Card Detail Standards) */
        .alert-summary {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .summary-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.03);
        }

        .summary-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .summary-card h2 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0 0 4px;
            color: #1e293b;
        }

        .summary-card p {
            font-size: 0.85rem;
            color: #64748b;
            margin: 0;
        }

        /* Items Requiring Attention Section */
        .attention-section {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.03);
        }

        .attention-section h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0 0 20px;
            color: #1e293b;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        .alerts-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            white-space: nowrap;
            font-size: 0.875rem;
        }

        .alerts-table thead th {
            font-size: 0.725rem;
            font-weight: 700;
            color: #64748b;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .alerts-table tbody td {
            font-size: 0.875rem;
            color: #334155;
            padding: 16px 12px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .alerts-table tbody tr:hover {
            background: #f8fafc;
        }

        .alerts-table tbody tr:last-child td {
            border-bottom: none;
        }

        .alerts-table .ingredient-name {
            font-weight: 700;
            color: #1e293b;
        }

        /* Alert Status Badges */
        .status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-critical {
            background: #fee2e2;
            color: #b91c1c;
        }

        .status-low {
            background: #fef3c7;
            color: #92400e;
        }

        .status-expiring {
            background: #ffedd5;
            color: #c2410c;
        }

        .status-expired {
            background: #f1f5f9;
            color: #475569;
        }

        /* Action Text */
        .action-text {
            color: var(--primary-green);
            font-weight: 600;
            cursor: pointer;
        }

        .action-text:hover {
            text-decoration: underline;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1100px) {
            .alert-summary {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .search-box {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="low-stock-layout">

    @include('sidebar')

    <main class="main-content low-stock-page">

        <!-- TOP NAVIGATION -->
        <header class="top-navbar">
            <div class="top-nav">
                Workspace / <span class="text-dark fw-medium">Low-Stock Alerts</span>
            </div>

            <div class="d-flex align-items-center gap-3">
                <form action="{{ route('low-stock-alert') }}" method="GET" class="search-box">
                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        name="search"
                        placeholder="Search ingredients..."
                        value="{{ request('search') }}"
                    >
                </form>

                <div class="d-flex align-items-center gap-2">
                    <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px; font-size: 0.85rem;">
                        AD
                    </div>
                    <div class="lh-1">
                        <div class="fw-bold" style="font-size: 0.85rem;">Admin</div>
                        <small class="text-secondary" style="font-size: 0.75rem;">Administrator</small>
                    </div>
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT CONTAINER -->
        <div class="low-stock-content">

            <!-- PAGE TITLE AND BUTTONS -->
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Low-Stock Alerts</h2>
                    <p class="text-secondary mb-0" style="font-size: 0.9rem;">Prioritize low quantities and ingredients nearing expiration.</p>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary bg-white text-dark border-secondary-subtle px-3 fw-medium">
                        Export alerts
                    </button>
                    <button type="button" class="btn btn-green px-3">
                        <i class="bi bi-plus-lg me-1"></i> Create request
                    </button>
                </div>
            </div>

            <!-- SUMMARY CARDS -->
            <section class="alert-summary">
                <div class="summary-card">
                    <span class="summary-label">CRITICAL</span>
                    <h2>{{ str_pad($criticalIngredients->count() ?? 0, 2, '0', STR_PAD_LEFT) }}</h2>
                    <p>Below 25% of minimum</p>
                </div>

                <div class="summary-card">
                    <span class="summary-label">LOW STOCK</span>
                    <h2>{{ str_pad($lowStockIngredients->count() ?? 0, 2, '0', STR_PAD_LEFT) }}</h2>
                    <p>Replenishment recommended</p>
                </div>

                <div class="summary-card">
                    <span class="summary-label">EXPIRING SOON</span>
                    <h2>{{ str_pad($expiringIngredients->count() ?? 0, 2, '0', STR_PAD_LEFT) }}</h2>
                    <p>Next 7 days</p>
                </div>

                <div class="summary-card">
                    <span class="summary-label">EXPIRED</span>
                    <h2>{{ str_pad($expiredIngredients->count() ?? 0, 2, '0', STR_PAD_LEFT) }}</h2>
                    <p>Review immediately</p>
                </div>
            </section>

            <!-- ITEMS REQUIRING ATTENTION -->
            <section class="attention-section">
                <h3>Items requiring attention</h3>

                <div class="table-container">
                    <table class="alerts-table">
                        <thead>
                            <tr>
                                <th>INGREDIENT</th>
                                <th>CURRENT STOCK</th>
                                <th>MINIMUM</th>
                                <th>EXPIRATION</th>
                                <th>ALERT</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($alerts ?? [] as $ingredient)
                                <tr>
                                    <td class="ingredient-name">
                                        {{ $ingredient->name }}
                                    </td>
                                    <td>
                                        {{ $ingredient->quantity }} {{ $ingredient->unit }}
                                    </td>
                                    <td>
                                        {{ $ingredient->min_quantity }} {{ $ingredient->unit }}
                                    </td>
                                    <td>
                                        @if ($ingredient->expiration_date)
                                            {{ \Carbon\Carbon::parse($ingredient->expiration_date)->format('M d, Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if ($ingredient->alert_status === 'Critical')
                                            <span class="status status-critical">Critical</span>
                                        @elseif ($ingredient->alert_status === 'Low Stock')
                                            <span class="status status-low">Low Stock</span>
                                        @elseif ($ingredient->alert_status === 'Expiring Soon')
                                            <span class="status status-expiring">Expiring Soon</span>
                                        @elseif ($ingredient->alert_status === 'Expired')
                                            <span class="status status-expired">Expired</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (in_array($ingredient->alert_status, ['Critical', 'Low Stock']))
                                            <a href="{{ route('ingredients.show', $ingredient->id) }}"
                                            class="action-text text-decoration-none">
                                                Create request
                                            </a>
                                        @else
                                            <a href="{{ route('ingredients.show', $ingredient->id) }}"
                                            class="action-text text-decoration-none">
                                                Review item
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-secondary py-4">
                                        No ingredients currently require attention.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </main>

</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>