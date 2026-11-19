<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockPilot - Inventory History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #111e2e;
            --sidebar-hover: #1c2d42;
            --sidebar-active: #1f3d45;
            --sidebar-active-border: #107c57;
            --primary-green: #146c43;
            --primary-green-hover: #105836;
            --light-bg: #f6f8fa;
            --border-color: #e5e9f0;
            --text-dark: #111827;
            --text-muted: #6b7280;
        }
        body {
            background-color: var(--light-bg);
            font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            color: var(--text-dark);
        }
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .top-navbar {
            background-color: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 16px 32px;
        }
        .breadcrumb-text {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-bottom: 2px;
        }
        .header-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 0.875rem;
        }
        .avatar-circle {
            width: 38px;
            height: 38px;
            background-color: #dcfce7;
            color: var(--primary-green);
            font-weight: 700;
            font-size: 0.85rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .page-wrapper {
            padding: 28px 32px;
        }
        .btn-custom-green {
            background-color: var(--primary-green);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 9px 18px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: background-color 0.15s ease;
        }
        .btn-custom-green:hover {
            background-color: var(--primary-green-hover);
            color: #ffffff;
        }
        .btn-custom-outline {
            background-color: #ffffff;
            color: var(--text-dark);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 9px 18px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: background-color 0.15s ease;
        }
        .btn-custom-outline:hover {
            background-color: #f9fafb;
            color: var(--text-dark);
        }
        .custom-card {
            background-color: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
        }
        .filter-input, .filter-select {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.875rem;
            padding: 8px 14px;
            color: var(--text-dark);
            height: 40px;
        }
        .filter-input-search {
            padding-left: 36px;
        }
        .filter-input:focus, .filter-select:focus {
            box-shadow: none;
            border-color: #9ca3af;
        }
        .table-records-info {
            font-size: 0.825rem;
            color: var(--text-muted);
            margin-bottom: 18px;
        }
        .custom-table {
            margin-bottom: 0;
        }
        .custom-table thead th {
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #6b7280;
            border-bottom: 1px solid var(--border-color);
            padding: 12px 16px;
            background-color: transparent;
        }
        .custom-table tbody td {
            padding: 18px 16px;
            font-size: 0.875rem;
            color: #374151;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }
        .custom-table tbody td:first-child {
            font-weight: 600;
            color: #111827;
        }
        .pagination-box {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .page-btn {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background-color: #ffffff;
            color: var(--text-dark);
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .page-btn:hover {
            background-color: #f3f4f6;
            color: var(--text-dark);
        }
        .page-btn.active {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
            color: #ffffff;
        }
        .page-btn.disabled {
            pointer-events: none;
            opacity: 0.5;
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
        <header class="top-navbar d-flex justify-content-between align-items-center">
            <div>
                <div class="breadcrumb-text">Workspace &nbsp;/&nbsp; Inventory History</div>
                <h2 class="h5 fw-bold mb-0 text-dark">Inventory History</h2>
            </div>

            <div class="d-flex align-items-center gap-4">
                <div class="d-none d-md-block">
                    @include('global-search')
                </div>

                <div class="d-flex align-items-center gap-2">
                    <div class="avatar-circle">AD</div>
                    <div class="lh-sm">
                        <div class="fw-semibold" style="font-size: 0.85rem;">Admin</div>
                        <div class="text-muted" style="font-size: 0.72rem;">Administrator</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="page-wrapper">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <h1 class="h3 fw-bold text-dark mb-1">Inventory History</h1>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">Review stock-in and stock-out activity with user and date details.</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" id="exportHistoryBtn" class="btn btn-custom-outline">
                        <i class="bi bi-download me-1"></i>Export
                    </button>
                </div>
            </div>

            <div class="custom-card p-3 mb-4">
                <form method="GET" action="{{ route('inventory.history') }}" class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="d-flex flex-wrap align-items-center gap-3 flex-grow-1">
                        <div class="position-relative" style="min-width: 260px;">
                            <i class="bi bi-search header-search-icon"></i>
                            <input type="text" name="search" class="form-control filter-input filter-input-search" placeholder="Search by name or keyword" value="{{ request('search') }}">
                        </div>

                        <div style="min-width: 165px;">
                            <select name="category" class="form-select filter-select">
                                <option value="">All categories</option>
                                <option value="Stock-In" {{ request('category') == 'Stock-In' ? 'selected' : '' }}>Stock-In</option>
                                <option value="Stock-Out" {{ request('category') == 'Stock-Out' ? 'selected' : '' }}>Stock-Out</option>
                            </select>
                        </div>

                        <div style="min-width: 150px;">
                            <select name="status" class="form-select filter-select">
                                <option value="">All status</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-custom-green px-4">Apply filters</button>
                    </div>
                </form>
            </div>

            <div class="custom-card p-4">
                <div class="table-records-info">
                    Showing records {{ $histories->firstItem() ?? 0 }}–{{ $histories->lastItem() ?? 0 }} of {{ $histories->total() }}
                </div>

                <div class="table-responsive" style="min-height: 360px;">
                    <table id="historyTable" class="table custom-table">
                        <thead>
                            <tr>
                                <th>DATE &amp; TIME</th>
                                <th>INGREDIENT</th>
                                <th>TYPE</th>
                                <th>QUANTITY</th>
                                <th>RECORDED BY</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($histories->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">
                                        <i class="bi bi-clock-history fs-3 d-block mb-2"></i>
                                        No inventory activities found.
                                    </td>
                                </tr>
                            @else
                                @foreach($histories as $history)
                                    <tr>
                                        <td>
                                            {{ \Carbon\Carbon::parse($history->created_at)->format('M d, Y') }}
                                            <br>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($history->created_at)->format('h:i A') }}
                                            </small>
                                        </td>
                                        <td>{{ $history->ingredient_name }}</td>
                                        <td>
                                            @if($history->transaction_type == 'Stock-In')
                                                <span class="badge bg-success-subtle text-success">Stock-In</span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger">Stock-Out</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($history->transaction_type == 'Stock-In')
                                                <span class="text-success fw-semibold">
                                                    + {{ $history->quantity }}
                                                </span>
                                            @else
                                                <span class="text-danger fw-semibold">
                                                    - {{ $history->quantity }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $history->recorded_by }}</td>
                                        <td>
                                            <span class="badge bg-success-subtle text-success">
                                                Completed
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 pt-2">
                    <div class="text-muted" style="font-size: 0.825rem;">
                        Showing page {{ $histories->currentPage() }}
                        of {{ $histories->lastPage() }}
                    </div>

                    <div class="pagination-box">
                        <a href="{{ $histories->previousPageUrl() ?? '#' }}"
                           class="page-btn {{ $histories->onFirstPage() ? 'disabled' : '' }}"
                           aria-label="Previous">
                            <i class="bi bi-chevron-left"></i>
                        </a>

                        @for($page = 1; $page <= $histories->lastPage(); $page++)
                            <a href="{{ $histories->url($page) }}"
                               class="page-btn {{ $histories->currentPage() == $page ? 'active' : '' }}">
                                {{ $page }}
                            </a>
                        @endfor

                        <a href="{{ $histories->nextPageUrl() ?? '#' }}"
                           class="page-btn {{ $histories->hasMorePages() ? '' : 'disabled' }}"
                           aria-label="Next">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('exportHistoryBtn')?.addEventListener('click', function () {
            const table = document.getElementById('historyTable');
            if (!table) return;

            const csvLines = Array.from(table.querySelectorAll('tr'))
                .filter(row => !row.querySelector('td[colspan]'))
                .map(row => Array.from(row.querySelectorAll('th, td'))
                    .map(cell => '"' + cell.innerText.trim().replace(/\s+/g, ' ').replace(/"/g, '""') + '"')
                    .join(','));

            const blob = new Blob([csvLines.join('\n')], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'inventory-history.csv';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
        });
    </script>
</body>
</html>