<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockPilot - Inventory Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #111e2e;
            --sidebar-hover: #1c2d42;
            --sidebar-active: #1f3d45;
            --sidebar-active-border: #107c57;
            --primary-green: #107c57;
            --light-bg: #f4f6f8;
        }
        body {
            background-color: var(--light-bg);
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
        }
        .main-content {
            margin-left: 260px;
            padding: 30px;
        }
        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
    </style>
</head>
<body>

    @if(view()->exists('layouts.sidebar'))
        @include('layouts.sidebar')
    @else
        @include('sidebar')
    @endif

    <div class="main-content">
        <div class="container-fluid px-4">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <span class="text-muted small">Workspace / Inventory Reports</span>
                    <h1 class="h3 fw-bold text-dark mt-1">Inventory Reports</h1>
                    <p class="text-muted mb-0">Review inventory movement, request activity, and category summaries.</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary bg-white px-3">Export PDF</button>
                    <button class="btn btn-success px-4" style="background-color: #107c57;">Generate report</button>
                </div>
            </div>

            <!-- Filters Bar -->
            <div class="card mb-4 p-3 bg-white">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="small text-muted fw-bold d-block mb-1">PERIOD</label>
                        <select class="form-select border-0 bg-light">
                            <option>Last 30 days</option>
                            <option>Last 7 days</option>
                            <option>This year</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="small text-muted fw-bold d-block mb-1">CATEGORY</label>
                        <select class="form-select border-0 bg-light">
                            <option>All categories</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="small text-muted fw-bold d-block mb-1">TRANSACTION TYPE</label>
                        <select class="form-select border-0 bg-light">
                            <option>All transactions</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Metric Cards Row -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card p-3 bg-white h-100">
                        <span class="text-muted small fw-bold">STOCK-IN VALUE</span>
                        <h3 class="fw-bold text-dark mt-2">₱ {{ number_format($stockInValue, 2) }}</h3>
                        <span class="text-muted small mt-1">Last 30 days</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 bg-white h-100">
                        <span class="text-muted small fw-bold">STOCK-OUT VALUE</span>
                        <h3 class="fw-bold text-dark mt-2">₱ {{ number_format($stockOutValue, 2) }}</h3>
                        <span class="text-muted small mt-1">Last 30 days</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 bg-white h-100">
                        <span class="text-muted small fw-bold">PURCHASE REQUESTS</span>
                        <h3 class="fw-bold text-dark mt-2">{{ $purchaseRequestsCount }}</h3>
                        <span class="text-muted small mt-1">Awaiting review</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 bg-white h-100">
                        <span class="text-muted small fw-bold">WASTE / EXPIRED</span>
                        <h3 class="fw-bold text-dark mt-2">₱ 0.00</h3>
                        <span class="text-muted small mt-1">Recorded losses</span>
                    </div>
                </div>
            </div>

            <!-- Charts & Category Section -->
            <div class="row g-4">
                <!-- Stock Movement Chart Mock / Empty State -->
                <div class="col-lg-8">
                    <div class="card p-4 bg-white h-100">
                        <h5 class="fw-bold text-dark">Stock movement</h5>
                        <p class="text-muted small">Monthly incoming vs outgoing quantities</p>
                        <div class="d-flex align-items-center justify-content-center text-muted" style="height: 220px;">
                            <div class="text-center">
                                <i class="bi bi-bar-chart fs-1 text-secondary opacity-50"></i>
                                <p class="small mb-0 mt-2">No movement data recorded yet.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- By Category Breakdown -->
                <div class="col-lg-4">
                    <div class="card p-4 bg-white h-100">
                        <h5 class="fw-bold text-dark mb-4">By category</h5>
                        @forelse($categorySummaries as $cat)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small fw-bold text-dark mb-1">
                                <span>{{ $cat->category_name }}</span>
                                <span>₱ {{ number_format($cat->total_value, 2) }}</span>
                            </div>
                            <div class="progress" style="height: 8px; background-color: #e9ecef;">
                                <div class="progress-bar" style="width: 100%; background-color: #107c57;"></div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-tags fs-2 text-secondary opacity-50"></i>
                            <p class="small mb-0 mt-2">No category inventory found.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>