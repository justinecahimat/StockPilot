<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockPilot - Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    :root {
        --light-bg: #f1f5f9;
        --primary-green: #2563eb;
        --primary-green-hover: #1d4ed8;
        --chart-bar-light: #93c5fd;
        --navy: #172554;
        --text-dark: #0f172a;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
    }

    body {
        background-color: var(--light-bg);
        font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
        color: var(--text-dark);
    }

    /* Main Content */
    .main-content {
        flex: 1;
        margin-left: 260px;
        height: 100vh;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 30px 36px;
    }

    .top-nav {
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    /* Buttons */
    .btn-green {
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        color: #fff;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        padding: 10px 18px;
        transition: all 0.2s ease;
    }

    .btn-green:hover {
        background: linear-gradient(135deg, #1d4ed8, #4338ca);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.2);
    }

    /* Metric Cards */
    .card-stat {
        position: relative;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        background: #fff;
        padding: 24px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.03);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card-stat:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
    }

    .card-stat::after {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(180deg, #3b82f6, #14b8a6);
        opacity: 0.8;
    }

    .card-stat .stat-title {
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        letter-spacing: 0.7px;
    }

    .card-stat .stat-value {
        font-size: 2.4rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
        margin: 12px 0;
    }

    .card-stat .stat-desc {
        font-size: 0.8rem;
        color: #94a3b8;
    }

    /* Dashboard Cards */
    .main-content .card {
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 5px 20px rgba(15, 23, 42, 0.04) !important;
        transition: box-shadow 0.2s ease;
    }

    .main-content .card:hover {
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.07) !important;
    }

    /* Inventory Chart */
    .chart-container {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        height: 190px;
        padding: 20px 8px 0;
        gap: 12px;
    }

    .chart-bar-group {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        flex: 1;
        height: 100%;
        justify-content: flex-end;
    }

    .chart-bar {
        width: 42px;
        max-width: 100%;
        max-height: calc(100% - 28px);
        border-radius: 10px 10px 5px 5px;
        background: linear-gradient(180deg, #60a5fa, #2563eb);
        transition: height 0.35s ease, filter 0.2s ease;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.12);
    }

    .chart-bar:hover {
        filter: brightness(1.12);
        background: linear-gradient(180deg, #2dd4bf, #0d9488);
    }

    .chart-label {
        font-size: 0.8rem;
        font-weight: 500;
        color: #64748b;
    }

    /* Low Stock Watchlist */
    .main-content .border-bottom {
        border-color: #f1f5f9 !important;
    }

    .main-content .badge {
        border-radius: 8px;
        padding: 6px 10px;
        font-weight: 600;
    }

    /* Recent Activity Table */
    .table-activity {
        font-size: 0.875rem;
    }

    .table-activity thead {
        background: #f8fafc;
    }

    .table-activity th {
        font-weight: 700;
        font-size: 0.72rem;
        color: #64748b;
        letter-spacing: 0.6px;
        border-bottom: 1px solid #e2e8f0;
        padding: 14px 16px;
        white-space: nowrap;
    }

    .table-activity td {
        padding: 17px 16px;
        vertical-align: middle;
        color: #334155;
        border-bottom-color: #f1f5f9;
    }

    .table-activity tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-activity tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Responsive Layout */
    @media (max-width: 992px) {
        .main-content {
            margin-left: 0;
            padding: 24px;
        }
    }

    @media (max-width: 576px) {
        .main-content {
            padding: 16px;
        }

        .card-stat {
            padding: 18px;
        }

        .card-stat .stat-value {
            font-size: 1.9rem;
        }

        .chart-container {
            gap: 6px;
        }

        .chart-bar {
            width: 28px;
        }
    }
    /* Metric Card Icons */
    .stat-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }

    .stat-icon-blue {
        background: #dbeafe;
        color: #2563eb;
    }

    .stat-icon-red {
        background: #fee2e2;
        color: #dc2626;
    }

    .stat-icon-purple {
        background: #ede9fe;
        color: #7c3aed;
    }

    .stat-icon-orange {
        background: #ffedd5;
        color: #ea580c;
    }
    /* Modern dashboard table */
.table thead th {
    background: #f8fafc;
    color: #64748b;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    border-bottom: 1px solid #e2e8f0;
    padding: 14px 16px;
    white-space: nowrap;
}

.table tbody td {
    padding: 14px 16px;
    vertical-align: middle;
    color: #475569;
    font-size: 0.875rem;
    border-bottom: 1px solid #f1f5f9;
}

.table tbody tr:last-child td {
    border-bottom: none;
}

.table tbody tr:hover {
    background-color: #f8fafc;
}
    </style>
    <link rel="stylesheet" href="{{ asset('css/stockpilot-pro.css') }}">
</head>
<body>

<div class="d-flex">
    @include('sidebar')

    <!-- Main Content Area -->
    <main class="main-content">
        <!-- Top Navbar -->
        <header class="d-flex justify-content-between align-items-center mb-4">
            <div class="top-nav">
                Workspace / <span class="text-dark fw-medium">Dashboard</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                @include('global-search')
                <div class="d-flex align-items-center gap-2">
            <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center fw-bold"
                style="width: 36px; height: 36px; font-size: 0.85rem;">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>

            <div class="lh-1">
                <div class="fw-bold" style="font-size: 0.85rem;">
                    {{ auth()->user()->name }}
                </div>

                <small class="text-secondary" style="font-size: 0.75rem;">
                    {{ auth()->user()->role }}
                </small>
            </div>
        </div>
            </div>
        </header>

        <!-- Page Heading & Action -->
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Dashboard</h2>
                <p class="text-secondary mb-0" style="font-size: 0.9rem;">A clear overview of ingredient stock, alerts, and pending purchase requests.</p>
            </div>
            <div>
                <button class="btn btn-green shadow-sm px-3"
                        data-bs-toggle="modal"
                        data-bs-target="#addIngredientModal">
                    + Add ingredient
                </button>
            </div>
        </div>


    <!-- Metric Cards -->
    <div class="row g-3 mb-4">

        <!-- Total Ingredients -->
        <div class="col-xl-3 col-sm-6">
            <div class="card-stat h-100">
                <div class="stat-card-top">
                    <div>
                        <div class="stat-title">TOTAL INGREDIENTS</div>
                        <div class="stat-value">{{ $totalIngredients }}</div>
                    </div>
                    <div class="stat-icon stat-icon-blue">
                        <i class="bi bi-box-seam"></i>
                    </div>
                </div>
                <div class="stat-desc">
                    <i class="bi bi-collection me-1"></i>
                    Across all categories
                </div>
            </div>
        </div>

    <!-- Low Stock -->
    <div class="col-xl-3 col-sm-6">
        <div class="card-stat h-100">
            <div class="stat-card-top">
                <div>
                    <div class="stat-title">LOW STOCK ITEMS</div>
                    <div class="stat-value">{{ $lowStockCount }}</div>
                </div>
                <div class="stat-icon stat-icon-red">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
            </div>
            <div class="stat-desc">
                <i class="bi bi-arrow-down-circle me-1"></i>
                Need attention
            </div>
        </div>
    </div>

    <!-- Pending Requests -->
    <div class="col-xl-3 col-sm-6">
        <div class="card-stat h-100">
            <div class="stat-card-top">
                <div>
                    <div class="stat-title">PENDING REQUESTS</div>
                    <div class="stat-value">{{ $pendingRequestsCount }}</div>
                </div>
                <div class="stat-icon stat-icon-purple">
                    <i class="bi bi-clipboard-check"></i>
                </div>
            </div>
            <div class="stat-desc">
                <i class="bi bi-clock me-1"></i>
                Awaiting review
            </div>
        </div>
    </div>

    <!-- Expiring Soon -->
    <div class="col-xl-3 col-sm-6">
        <div class="card-stat h-100">
            <div class="stat-card-top">
                <div>
                    <div class="stat-title">EXPIRING SOON</div>
                    <div class="stat-value">{{ $expiringSoonCount }}</div>
                </div>
                <div class="stat-icon stat-icon-orange">
                    <i class="bi bi-calendar2-week"></i>
                </div>
            </div>
            <div class="stat-desc">
                <i class="bi bi-calendar-event me-1"></i>
                Within the next 7 days
            </div>
        </div>
    </div>

</div>


        <!-- Middle Section (Chart + Watchlist) -->
        <div class="row g-3 mb-4">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-3">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">
                            <i class="bi bi-bar-chart-line text-primary me-2"></i>
                            Inventory overview
                        </h5>
                        <p class="text-secondary mb-0" style="font-size: 0.85rem;">
                            Stock activity · Last 7 days
                        </p>
                    </div>

                    <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                        <i class="bi bi-calendar3 me-1"></i>
                        Weekly
                    </span>
                </div>

                    @php
                        $bars = $overviewData ?? [
                            ['label' => 'Mon', 'value' => 0, 'display_value' => '0', 'height' => 4],
                            ['label' => 'Tue', 'value' => 0, 'display_value' => '0', 'height' => 4],
                            ['label' => 'Wed', 'value' => 0, 'display_value' => '0', 'height' => 4],
                            ['label' => 'Thu', 'value' => 0, 'display_value' => '0', 'height' => 4],
                            ['label' => 'Fri', 'value' => 0, 'display_value' => '0', 'height' => 4],
                            ['label' => 'Sat', 'value' => 0, 'display_value' => '0', 'height' => 4],
                            ['label' => 'Sun', 'value' => 0, 'display_value' => '0', 'height' => 4],
                        ];
                    @endphp

                    <div class="d-flex align-items-center gap-3 mb-2 small text-secondary">
                        <span class="d-flex align-items-center gap-2">
                            <span class="rounded-1 d-inline-block" style="width: 10px; height: 10px; background: #2563eb;"></span>
                            Stock movement
                        </span>
                    </div>

                    <div class="chart-container">
                        @foreach($bars as $day)
                            <div class="chart-bar-group">
                                <div
                                    class="chart-bar {{ ($day['value'] ?? 0) == 0 ? 'opacity-50' : '' }}"
                                    data-height="{{ (int) $day['height'] }}"
                                    title="{{ $day['label'] }}: {{ $day['display_value'] ?? $day['value'] }}">
                                </div>
                                <span class="chart-label">{{ $day['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <h5 class="fw-bold text-dark mb-0">Low-stock watchlist</h5>
                    <p class="text-secondary mb-3" style="font-size: 0.85rem;">Items below minimum quantity</p>

                    @forelse($lowStockItems as $item)
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon stat-icon-red" style="width: 40px; height: 40px; font-size: 1rem;">
                                <i class="bi bi-box-seam"></i>
                            </div>

                            <div>
                                <span class="fw-semibold text-dark">{{ $item->name }}</span>
                                <br>
                                <small class="text-secondary">
                                    Current stock:
                                    <span class="fw-semibold text-danger">{{ $item->quantity }}</span>
                                </small>
                            </div>
                        </div>

                        <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2">
                            <i class="bi bi-exclamation-circle me-1"></i>
                            Low
                        </span>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="bi bi-check-circle text-success fs-2"></i>
                        <p class="text-secondary mt-2 mb-0" style="font-size: 0.875rem;">
                            All ingredients are well stocked.
                        </p>
                    </div>
                @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Inventory Activity Table -->
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0">Recent inventory activity</h5>
                <a href="{{ route('inventory.history') }}" class="text-success text-decoration-none fw-medium" style="font-size: 0.875rem;">View history &rarr;</a>
            </div>

            <div class="table-responsive">
                <table class="table table-activity align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col">ITEM</th>
                            <th scope="col">TRANSACTION</th>
                            <th scope="col">QUANTITY</th>
                            <th scope="col">PERFORMED BY</th>
                            <th scope="col">DATE</th>
                            <th scope="col">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentActivities as $activity)
                            <tr>
                                <td>{{ $activity->ingredient->name ?? 'N/A' }}</td>
                                <td>{{ $activity->transaction_type }}</td>
                                <td>{{ $activity->quantity }}</td>
                                <td>{{ $activity->user->name ?? 'Admin' }}</td>
                                <td>{{ $activity->created_at->format('M d, Y h:i A') }}</td>
                                <td>
                                    <span class="badge bg-success-subtle text-success">Completed</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="stat-icon stat-icon-blue mb-3">
                                            <i class="bi bi-activity"></i>
                                        </div>

                                        <h6 class="fw-semibold text-dark mb-1">
                                            No recent activity
                                        </h6>

                                        <p class="text-secondary mb-0" style="font-size: 0.875rem;">
                                            Inventory transactions will appear here.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

@include('add-ingredient-modal')

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.chart-bar[data-height]').forEach(bar => {
        const height = Number(bar.dataset.height);

        if (Number.isFinite(height)) {
            bar.style.height = `${height}%`;
        }
    });
</script>
</body>
</html>
