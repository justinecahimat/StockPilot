
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockPilot - Request Details</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8fafc;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
        }

        .main-content {
            flex: 1;
            margin-left: 260px;
            height: 100vh;
            overflow-y: auto;
            padding: 0;
        }

        .top-navbar {
            height: 72px;
            min-height: 72px;
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 32px;
        }

        .page-content {
            padding: 24px 32px;
        }

        .detail-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 20px;
        }

        .detail-label {
            color: #64748b;
            font-size: 0.8rem;
            margin-bottom: 5px;
        }

        .detail-value {
            color: #1e293b;
            font-weight: 600;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 13px;
            border-radius: 20px;
            font-size: 0.8rem;
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

        .table th {
            color: #64748b;
            font-size: 0.75rem;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle;
        }
    </style>
</head>

<body>

<div class="d-flex">

    @include('sidebar')

    <main class="main-content">

        <!-- TOP NAVBAR -->
        <header class="top-navbar d-flex justify-content-between align-items-center">

            <div class="small text-secondary">
                Workspace /
                <a href="{{ route('purchase-request') }}"
                   class="text-decoration-none text-secondary">
                    Purchase Requests
                </a>
                / <span class="text-dark fw-semibold">Request Details</span>
            </div>

            <div class="d-flex align-items-center gap-3">

                @include('global-search')

                <div class="d-flex align-items-center gap-2">
                    <div class="bg-light rounded-circle rounded-circle d-flex align-items-center justify-content-center fw-bold"
                         style="width: 36px; height: 36px; font-size: .85rem; background-color: #F0EDFF !important; color: #6D5CE7 !important;">
                         AD
                    </div>

                    <div class="lh-1">
                        <div class="fw-bold small">
                            {{ auth()->user()->name }}
                        </div>
                        <small class="text-secondary">
                            {{ ucfirst(strtolower(auth()->user()->role)) }}
                        </small>
                    </div>
                </div>

            </div>
        </header>

        <div class="page-content">

            <!-- PAGE HEADING -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

                <div>
                    <h3 class="fw-bold text-dark mb-1">Request Details</h3>
                    <p class="text-secondary mb-0 small">
                        Review the submitted purchase request and its items.
                    </p>
                </div>

                <a href="{{ route('purchase-request') }}"
                   class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Back to Requests
                </a>

            </div>

            @php
                $total = $request->items->sum(function ($item) {
                    return $item->requested_quantity * $item->unit_cost;
                });

                $status = strtolower($request->status);
            @endphp

            <!-- REQUEST INFORMATION -->
            <div class="detail-card shadow-sm">

                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

                    <div>
                        <h5 class="fw-bold mb-1">
                            {{ $request->reference_no }}
                        </h5>

                        <span class="text-secondary small">
                            Purchase Request Information
                        </span>
                    </div>

                    <span class="status-badge
                        {{ $status === 'approved' ? 'status-approved' :
                           ($status === 'rejected' ? 'status-rejected' : 'status-pending') }}">
                        {{ ucfirst($request->status) }}
                    </span>

                </div>

                <div class="row g-4">

                    <div class="col-md-4">
                        <div class="detail-label">Requested By</div>
                        <div class="detail-value">
                            {{ $request->requester->name ?? 'Unknown' }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="detail-label">Date Submitted</div>
                        <div class="detail-value">
                            {{ $request->created_at?->format('M d, Y h:i A') ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="detail-label">Estimated Total</div>
                        <div class="detail-value text-success">
                            ₱ {{ number_format($total, 2) }}
                        </div>
                    </div>

                    @if($request->approved_by)
                        <div class="col-md-4">
                            <div class="detail-label">{{ $request->status === 'rejected' ? 'Rejected By' : 'Approved By' }}</div>
                            <div class="detail-value">
                                {{ $request->approver?->name ?? '' }}
                            </div>
                        </div>
                    @endif

                    @if($request->approved_at)
                        <div class="col-md-4">
                            <div class="detail-label">{{ $request->status === 'rejected' ? 'Rejection Date' : 'Approval Date' }}</div>
                            <div class="detail-value">
                                {{ $request->approved_at?->format('M d, Y h:i A') ?? '' }}
                            </div>
                        </div>
                    @endif

                @if($request->status === 'rejected' && $request->rejection_reason)
                    <div class="alert alert-danger mt-3">
                        <h6 class="fw-bold mb-2">
                            <i class="bi bi-exclamation-circle me-1"></i>
                            Rejection Reason
                        </h6>

                        <p class="mb-0">
                            {{ $request->rejection_reason }}
                        </p>
                    </div>
                @endif

                </div>

            </div>

            <!-- REQUESTED ITEMS -->
            <div class="detail-card shadow-sm">

                <h5 class="fw-bold mb-1">Requested Items</h5>

                <p class="text-secondary small mb-4">
                    Ingredients included in this purchase request.
                </p>

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>
                            <tr>
                                <th>INGREDIENT</th>
                                <th>CURRENT STOCK</th>
                                <th>REQUESTED QTY</th>
                                <th>UNIT COST</th>
                                <th>SUBTOTAL</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($request->items as $item)

                                <tr>
                                    <td class="fw-semibold text-dark">
                                        {{ $item->ingredient->name ?? 'Unknown Ingredient' }}
                                    </td>

                                    <td>
                                        {{ number_format($item->current_stock, 2) }}
                                        {{ $item->unit }}
                                    </td>

                                    <td>
                                        {{ number_format($item->requested_quantity, 2) }}
                                        {{ $item->unit }}
                                    </td>

                                    <td>
                                        ₱ {{ number_format($item->unit_cost, 2) }}
                                    </td>

                                    <td class="fw-semibold">
                                        ₱ {{ number_format($item->requested_quantity * $item->unit_cost, 2) }}
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center text-secondary py-4">
                                        No items found in this request.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">
                                    Estimated Total
                                </td>
                                <td class="fw-bold text-success">
                                    ₱ {{ number_format($total, 2) }}
                                </td>
                            </tr>
                        </tfoot>

                    </table>

                </div>

            </div>

            <!-- ADMIN APPROVAL ACTION -->
            @if(auth()->user()->role === 'Admin' && $status === 'pending')
                <div class="d-flex gap-2 flex-wrap">

                    {{-- Approve Request --}}
                    <form action="{{ route('purchase-request.approve', $request->id) }}"
                        method="POST">
                        @csrf
                        @method('PATCH')

                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i>
                            Approve Request
                        </button>
                    </form>

                    {{-- Reject Request --}}
                    <button type="button"
                            class="btn btn-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#rejectRequestModal">
                        <i class="bi bi-x-circle me-1"></i>
                        Reject Request
                    </button>

                </div>
            @endif

        </div>

    </main>

</div>

{{-- Reject Request Modal --}}
<div class="modal fade" id="rejectRequestModal" tabindex="-1"
     aria-labelledby="rejectRequestModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('purchase-request.reject', $request->id) }}"
                  method="POST">
                @csrf
                @method('PATCH')

                <div class="modal-header">
                    <h5 class="modal-title" id="rejectRequestModalLabel">
                        Reject Purchase Request
                    </h5>

                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p>
                        Please provide a reason for rejecting
                        <strong>{{ $request->reference_no }}</strong>.
                    </p>

                    <label for="rejection_reason" class="form-label">
                        Rejection Reason <span class="text-danger">*</span>
                    </label>

                    <textarea
                        name="rejection_reason"
                        id="rejection_reason"
                        class="form-control"
                        rows="4"
                        maxlength="1000"
                        required
                        placeholder="Explain why this purchase request is being rejected..."
                    >{{ old('rejection_reason') }}</textarea>

                    @error('rejection_reason')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-danger">
                        Confirm Rejection
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
