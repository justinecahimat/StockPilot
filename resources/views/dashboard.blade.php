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
        

        body {
            background-color: var(--light-bg);
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
        }


        .main-content {
            flex: 1;
            margin-left: 260px;

            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;

            padding: 24px 32px;
        }

        .top-nav {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .btn-green {
            background-color: var(--primary-green);
            color: white;
            font-weight: 500;
        }

        .btn-green:hover {
            background-color: var(--primary-green-hover);
            color: white;
        }

        /* Metric Cards */
        .card-stat {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #ffffff;
            padding: 20px;
        }

        .card-stat .stat-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            letter-spacing: 0.5px;
        }

        .card-stat .stat-value {
            font-size: 2.25rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.2;
            margin: 8px 0;
        }

        .card-stat .stat-desc {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        /* Custom Bar Chart Visual */
        .chart-container {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            height: 180px;
            padding-top: 20px;
        }

        .chart-bar-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            flex: 1;
        }

        .chart-bar {
            width: 38px;
            border-radius: 6px;
            background-color: var(--chart-bar-light);
            height: 0%;
        }

        .chart-label {
            font-size: 0.8rem;
            color: #64748b;
        }

        /* Table Customization */
        .table-activity {
            font-size: 0.875rem;
        }

        .table-activity th {
            font-weight: 600;
            font-size: 0.725rem;
            color: #64748b;
            letter-spacing: 0.5px;
            border-bottom-width: 1px;
            padding-bottom: 12px;
        }

        .table-activity td {
            padding: 16px 12px;
            vertical-align: middle;
            color: #334155;
            border-bottom-color: #f1f5f9;
        }
    </style>
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
                <div class="position-relative" style="width: 260px;">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
                    <input type="text" class="form-control form-control-sm ps-5 bg-white border-0 shadow-sm" placeholder="Search anything...">
                </div>
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
            <div class="col-md-3">
                <div class="card-stat">
                    <div class="stat-title">TOTAL INGREDIENTS</div>
                    <div class="stat-value">{{ $totalIngredients }}</div>
                    <div class="stat-desc">Across all categories</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-stat">
                    <div class="stat-title">LOW STOCK ITEMS</div>
                    <div class="stat-value">{{ $lowStockCount }}</div>
                    <div class="stat-desc">Need attention today</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-stat">
                    <div class="stat-title">PENDING REQUESTS</div>
                    <div class="stat-value">{{ $pendingRequestsCount }}</div>
                    <div class="stat-desc">Awaiting manager review</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-stat">
                    <div class="stat-title">EXPIRING SOON</div>
                    <div class="stat-value">{{ $expiringSoonCount }}</div>
                    <div class="stat-desc">Within the next 7 days</div>
                </div>
            </div>
        </div>

        <!-- Middle Section (Chart + Watchlist) -->
        <div class="row g-3 mb-4">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <h5 class="fw-bold text-dark mb-0">Inventory overview</h5>
                    <p class="text-secondary mb-3" style="font-size: 0.85rem;">Stock activity · Last 7 days</p>
                    
                    <div class="chart-container">
                        <div class="chart-bar-group"><div class="chart-bar"></div><span class="chart-label">Mon</span></div>
                        <div class="chart-bar-group"><div class="chart-bar"></div><span class="chart-label">Tue</span></div>
                        <div class="chart-bar-group"><div class="chart-bar"></div><span class="chart-label">Wed</span></div>
                        <div class="chart-bar-group"><div class="chart-bar"></div><span class="chart-label">Thu</span></div>
                        <div class="chart-bar-group"><div class="chart-bar"></div><span class="chart-label">Fri</span></div>
                        <div class="chart-bar-group"><div class="chart-bar"></div><span class="chart-label">Sat</span></div>
                        <div class="chart-bar-group"><div class="chart-bar"></div><span class="chart-label">Sun</span></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <h5 class="fw-bold text-dark mb-0">Low-stock watchlist</h5>
                    <p class="text-secondary mb-3" style="font-size: 0.85rem;">Items below minimum quantity</p>
                    
                    @forelse($lowStockItems as $item)
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                            <div>
                                <span class="fw-medium text-dark">{{ $item->name }}</span>
                                <br><small class="text-danger">Stock: {{ $item->quantity }}</small>
                            </div>
                            <span class="badge bg-danger-subtle text-danger">Low</span>
                        </div>
                    @empty
                        <div class="text-secondary text-center py-4" style="font-size: 0.875rem;">No low-stock items found.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Inventory Activity Table -->
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0">Recent inventory activity</h5>
                <a href="#" class="text-success text-decoration-none fw-medium" style="font-size: 0.875rem;">View history &rarr;</a>
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
                                <td colspan="6" class="text-center text-secondary py-4">No recent activity recorded.</td>
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
</body>
</html>