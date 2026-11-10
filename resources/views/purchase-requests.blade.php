
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockPilot - Purchase Requests</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
        }

        .main-content {
            flex: 1;
            margin-left: 260px;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 0;
        }

        .top-navbar {
            height: 72px;
            min-height: 72px;
            background-color: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 32px;
        }

        .page-content {
            padding: 24px 32px;
        }

        .top-nav {
            font-size: 0.85rem;
            color: #6c757d;
        }

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
        }

        .request-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
        }

        .table-requests {
            font-size: 0.875rem;
        }

        .table-requests th {
            font-size: 0.725rem;
            font-weight: 700;
            color: #64748b;
            letter-spacing: 0.5px;
            padding: 14px 12px;
            white-space: nowrap;
        }

        .table-requests td {
            padding: 17px 12px;
            vertical-align: middle;
            color: #334155;
            border-bottom-color: #f1f5f9;
        }

        .request-id {
            font-weight: 700;
            color: #146c43;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 11px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-approved {
            background: #dcfce7;
            color: #166534;
        }

        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-view {
            color: var(--primary-green);
            border: 1px solid #cbd5e1;
            background: #fff;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .btn-view:hover {
            background: #f0fdf4;
            color: var(--primary-green-hover);
        }
    </style>
</head>

<body>

<div class="d-flex">

    @include('sidebar')

    <main class="main-content">

        <!-- TOP NAVBAR -->
        <header class="top-navbar d-flex justify-content-between align-items-center mb-4">

            <div class="top-nav">
                Workspace /
                <span class="text-dark fw-medium">Purchase Requests</span>
                <h2 class="text-dark fw-medium mb-0">Purchase Requests</h2>
            </div>

            <div class="d-flex align-items-center gap-3">

                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Search anything...">
                </div>

                <div class="d-flex align-items-center gap-2">
                    <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center fw-bold"
                         style="width: 36px; height: 36px; font-size: 0.85rem;">
                        AD
                    </div>

                    <div class="lh-1">
                        <div class="fw-bold" style="font-size: 0.85rem;">Admin</div>
                        <small class="text-secondary" style="font-size: 0.75rem;">
                            Administrator
                        </small>
                    </div>
                </div>

            </div>
        </header>


        <div class="page-content">

            <!-- PAGE HEADING -->
            <div class="d-flex justify-content-between align-items-end mb-4">

                <!-- PAGE HEADING -->
                <div class="d-flex justify-content-between align-items-end mb-4">

                    <div>
                        <h2 class="fw-bold text-dark mb-1">Purchase Requests</h2>

                        <p class="text-secondary mb-0" style="font-size: 0.9rem;">
                            Review and manage ingredient replenishment requests.
                        </p>
                    </div>

                    <button type="button"
                            class="btn btn-success px-3"
                            data-bs-toggle="modal"
                            data-bs-target="#createPurchaseRequestModal">

                        <i class="bi bi-plus-lg me-1"></i>
                        Create Request

                    </button>

                </div>

            </div>


            <!-- REQUEST TABLE -->
            <div class="request-card shadow-sm">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>
                        <h5 class="fw-bold text-dark mb-1">All Requests</h5>

                        <p class="text-secondary mb-0" style="font-size: 0.85rem;">
                            View submitted purchase requests and their status.
                        </p>
                    </div>

                    <span class="badge bg-success-subtle text-success px-3 py-2">
                        {{ $requests->count() }} Requests
                    </span>

                </div>


                <div class="table-responsive">

                    <table class="table table-requests align-middle mb-0">

                        <thead>
                            <tr>
                                <th>REQUEST ID</th>
                                <th>REQUESTED BY</th>
                                <th>ITEMS</th>
                                <th>EST. TOTAL</th>
                                <th>DATE</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($requests as $request)

                                @php
                                    $total = $request->items->sum(function ($item) {
                                        return $item->requested_quantity * $item->unit_cost;
                                    });

                                    $status = strtolower($request->status);
                                @endphp

                                <tr>

                                    <td>
                                        <span class="request-id">
                                            {{ $request->reference_no }}
                                        </span>
                                    </td>

                                    <td class="fw-medium">
                                        {{ $request->requester->name ?? 'Unknown' }}
                                    </td>

                                    <td>
                                        {{ $request->items->count() }} items
                                    </td>

                                    <td class="fw-semibold text-dark">
                                        ₱ {{ number_format($total, 2) }}
                                    </td>

                                    <td>
                                        {{ $request->created_at->format('M d, Y') }}
                                    </td>

                                    <td>
                                        <span class="status-badge
                                            {{ $status === 'approved' ? 'status-approved' :
                                               ($status === 'rejected' ? 'status-rejected' : 'status-pending') }}">

                                            {{ ucfirst($request->status) }}

                                        </span>
                                    </td>

                                    <td>
                                        <a href="{{ route('purchase-request.show', $request->id) }}"
                                           class="btn btn-view px-3 py-2">
                                            <i class="bi bi-eye me-1"></i>
                                            View
                                        </a>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="text-center text-secondary py-5">
                                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                        No purchase requests found.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </main>

</div>

@include('purchase-requests.create-modal')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>