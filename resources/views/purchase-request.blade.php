<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockPilot - Purchase Request Details</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>

        /* TOP NAVBAR */
        .top-navbar {
            height: 72px;
            min-height: 72px;
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 32px;
        }

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

        .main-content > .page-content {
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

        /* Detail Header Cards */
        .card-detail {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #ffffff;
            padding: 24px;
        }

        .detail-meta-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .badge-pending {
            background-color: #fef3c7;
            color: #92400e;
            font-weight: 600;
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 12px;
        }

        /* Table Styling */
        .table-items {
            font-size: 0.875rem;
        }

        .table-items th {
            font-weight: 700;
            font-size: 0.725rem;
            color: #64748b;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom-width: 1px;
            padding-bottom: 12px;
        }

        .table-items td {
            padding: 16px 12px;
            vertical-align: middle;
            color: #334155;
            border-bottom-color: #f1f5f9;
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
            color: #1e293b;
        }
    </style>
</head>
<body>

<div class="d-flex">
    @include('sidebar')

    <!-- Main Content Area -->
    <main class="main-content">
        <!-- Top Navbar -->
        <header class="top-navbar d-flex justify-content-between align-items-center mb-4">
            <div class="top-nav">
                Workspace / <span class="text-dark fw-medium">Purchase Request Details</span>

                <h2 class="text-dark fw-medium">Purchase Request</h2>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Search anything...">
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

        <div class="page-content">
                <!-- Page Heading & Actions -->
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <h2 class="fw-bold text-dark mb-1">Purchase Request Details</h2>
                        <p class="text-secondary mb-0" style="font-size: 0.9rem;">Review requested items, quantities, estimated costs, and approval actions.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-outline-secondary bg-white text-dark border-secondary-subtle px-3 fw-medium">Back to requests</a>
                        
                        <!-- Action Form / Button for Approval -->
                        <form action="#" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-green px-3">Approve request</button>
                        </form>
                    </div>
                </div>

                <!-- Top Details Overview Grid -->
                <div class="row g-3 mb-4">
                    <!-- Left Info Card -->
                    <div class="col-md-8">
                        <div class="card-detail shadow-sm h-100">
                            <div class="detail-meta-title mb-2">REQUEST #{{ $request->reference_no ?? 'PR-2026-008' }}</div>
                            <h3 class="fw-bold text-dark mb-2">{{ $request->title ?? 'Weekly kitchen replenishment' }}</h3>
                            
                            <div class="mb-3">
                                <span class="badge badge-pending">{{ ucfirst($request->status ?? 'Pending') }}</span>
                            </div>

                            <div class="text-secondary mb-3" style="font-size: 0.85rem;">
                                Created by <span class="fw-medium text-dark">{{ $request->creator->name ?? 'María Santos' }}</span> &bull; {{ isset($request) ? $request->created_at->format('M d, Y') : 'Oct 12, 2026' }}
                            </div>

                            <p class="text-secondary mb-0" style="font-size: 0.9rem;">
                                {{ $request->description ?? "Please replenish items listed for next week's menu." }}
                            </p>
                        </div>
                    </div>

                    <!-- Right Summary Card -->
                    <div class="col-md-4">
                        <div class="card-detail shadow-sm h-100">
                            <div class="detail-meta-title mb-2">ESTIMATED TOTAL</div>
                            <div class="fw-bold text-dark mb-3" style="font-size: 2rem;">
                                &#8369; {{ number_format($request->total_amount ?? 8450.00, 2) }}
                            </div>

                            <div class="text-secondary mb-2" style="font-size: 0.9rem;">
                                <span class="fw-medium text-dark">{{ $request->items_count ?? count($requestItems ?? [1,2,3,4]) }}</span> ingredients
                            </div>
                            <div class="fw-bold text-dark" style="font-size: 0.9rem;">
                                Within {{ $request->lead_time ?? '3–5 days' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Requested Items Table Section -->
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold text-dark mb-4">Requested items</h5>

                    <div class="table-responsive">
                        <table class="table table-items align-middle mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">INGREDIENT</th>
                                    <th scope="col">QUANTITY</th>
                                    <th scope="col">UNIT COST</th>
                                    <th scope="col">SUBTOTAL</th>
                                    <th scope="col">STOCK NOW</th>
                                    <th scope="col">REVIEW</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requestItems ?? [
                                    ['name' => 'Chicken breast', 'qty' => '10 kg', 'unit_cost' => 240.00, 'subtotal' => 2400.00, 'stock' => '2 kg', 'status' => 'Needs review'],
                                    ['name' => 'Cooking oil', 'qty' => '12 bottles', 'unit_cost' => 180.00, 'subtotal' => 2160.00, 'stock' => '3 bottles', 'status' => 'Needs review'],
                                    ['name' => 'Mozzarella cheese', 'qty' => '8 kg', 'unit_cost' => 310.00, 'subtotal' => 2480.00, 'stock' => '1.5 kg', 'status' => 'Needs review'],
                                    ['name' => 'Tomato sauce', 'qty' => '10 cans', 'unit_cost' => 85.00, 'subtotal' => 850.00, 'stock' => '4 cans', 'status' => 'Needs review']
                                ] as $item)
                                    <tr>
                                        <td class="fw-bold text-dark">{{ $item['name'] ?? $item->ingredient->name }}</td>
                                        <td>{{ $item['qty'] ?? ($item->quantity . ' ' . $item->unit) }}</td>
                                        <td>&#8369; {{ number_format($item['unit_cost'] ?? $item->unit_cost, 2) }}</td>
                                        <td>&#8369; {{ number_format($item['subtotal'] ?? $item->subtotal, 2) }}</td>
                                        <td>{{ $item['stock'] ?? ($item->ingredient->current_stock . ' ' . $item->unit) }}</td>
                                        <td class="text-secondary">{{ $item['status'] ?? ($item->review_status ?? 'Needs review') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-secondary py-4">No requested items found for this purchase request.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </main>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>