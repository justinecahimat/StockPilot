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

/* REPORT METRIC CARDS */
.report-metric-card {
    position: relative;
    overflow: hidden;
    border: 1px solid var(--metric-border) !important;
    border-radius: 16px !important;
    background: var(--metric-bg) !important;
    padding: 22px !important;
    min-height: 160px;
    box-shadow: 0 4px 14px rgba(30, 41, 59, 0.04) !important;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.report-metric-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(30, 41, 59, 0.10) !important;
}

.report-metric-card::after {
    content: "";
    position: absolute;
    right: -25px;
    top: -30px;
    width: 105px;
    height: 105px;
    border-radius: 50%;
    background: var(--metric-accent);
    opacity: 0.07;
    pointer-events: none;
}

.metric-card-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
}

.metric-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--metric-icon-bg);
    color: var(--metric-accent);
    font-size: 20px;
}

.report-metric-card .metric-label {
    color: #64748b;
    font-size: 0.76rem;
    font-weight: 750;
    letter-spacing: 0.45px;
}

.report-metric-card h3 {
    color: #1e293b;
    font-size: 1.75rem;
    font-weight: 800;
    letter-spacing: -0.6px;
    margin-top: 14px !important;
    margin-bottom: 5px;
}

.report-metric-card .metric-caption {
    color: #64748b;
    font-size: 0.82rem;
}

.metric-stock-in {
    --metric-accent: #6D5CE7;
    --metric-bg: #FBFAFF;
    --metric-border: #E7E1FF;
    --metric-icon-bg: #F0EDFF;
}

.metric-stock-out {
    --metric-accent: #3984DB;
    --metric-bg: #F8FBFF;
    --metric-border: #DCEBFF;
    --metric-icon-bg: #EAF3FF;
}

.metric-purchase {
    --metric-accent: #D99132;
    --metric-bg: #FFFCF6;
    --metric-border: #F7E9CC;
    --metric-icon-bg: #FFF3DB;
}

.metric-waste {
    --metric-accent: #DC626E;
    --metric-bg: #FFF9FA;
    --metric-border: #F7DFE2;
    --metric-icon-bg: #FDECEF;
}

@media (max-width: 576px) {
    .report-metric-card {
        min-height: 145px;
        padding: 18px !important;
    }

    .report-metric-card h3 {
        font-size: 1.5rem;
    }
}

    </style>
    <link rel="stylesheet" href="{{ asset('css/stockpilot-pro.css') }}">
</head>
<body>

    @if(view()->exists('layouts.sidebar'))
        @include('layouts.sidebar')
    @else
        @include('sidebar')
    @endif

    <div class="main-content">
        <div class="container-fluid px-4">
            <!-- Top Navigation Bar -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted small">Workspace / <span class="text-dark fw-medium">Inventory Reports</span></span>
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
                            {{ ucfirst(strtolower(auth()->user()->role)) }}
                        </small>
                    </div>
                </div>
                </div>
            </div>

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 fw-bold text-dark mt-1">Inventory Reports</h1>
                    <p class="text-muted mb-0">
                        Review inventory movement, request activity, and category summaries.
                        <span id="reportStatusText" class="badge bg-success-subtle text-success ms-2 fw-normal">
                            Showing: {{ $periodLabel ?? 'Last 30 days' }}
                        </span>
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" id="exportReportPdfBtn" onclick="exportInventoryReportPDF()" class="btn btn-outline-secondary bg-white px-3">
                        <i class="bi bi-file-earmark-pdf me-1 text-danger"></i>Export PDF
                    </button>
                    <button type="button" id="generateReportBtn" onclick="generateReport()" class="btn btn-success px-4" style="background-color: #107c57;">
                        <i class="bi bi-arrow-repeat me-1"></i>Generate report
                    </button>
                </div>
            </div>

            <!-- Filters Bar -->
            <div class="card mb-4 p-3 bg-white">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="small text-muted fw-bold d-block mb-1">PERIOD</label>
                        <select id="periodFilter" class="form-select border-0 bg-light">
                            <option value="Last 30 days" {{ ($selectedPeriod ?? 'Last 30 days') === 'Last 30 days' ? 'selected' : '' }}>Last 30 days</option>
                            <option value="Last 7 days" {{ ($selectedPeriod ?? '') === 'Last 7 days' ? 'selected' : '' }}>Last 7 days</option>
                            <option value="This year" {{ ($selectedPeriod ?? '') === 'This year' ? 'selected' : '' }}>This year</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="small text-muted fw-bold d-block mb-1">CATEGORY</label>
                        <select id="categoryFilter" class="form-select border-0 bg-light">
                            <option value="all">All categories</option>
                            @foreach(($availableCategories ?? $categorySummaries->pluck('category_name')) as $catName)
                                <option value="{{ $catName }}" {{ ($selectedCategory ?? 'all') === $catName ? 'selected' : '' }}>{{ $catName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="small text-muted fw-bold d-block mb-1">TRANSACTION TYPE</label>
                        <select id="transactionTypeFilter" class="form-select border-0 bg-light">
                            <option value="all" {{ ($selectedTransactionType ?? 'all') === 'all' ? 'selected' : '' }}>All transactions</option>
                            <option value="stock-in" {{ ($selectedTransactionType ?? '') === 'stock-in' ? 'selected' : '' }}>Stock-In only</option>
                            <option value="stock-out" {{ ($selectedTransactionType ?? '') === 'stock-out' ? 'selected' : '' }}>Stock-Out only</option>
                        </select>
                    </div>
                </div>
            </div>


<!-- Metric Cards Row -->
<div class="row g-4 mb-4">

    <!-- Stock-In -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card report-metric-card metric-stock-in h-100">
            <div class="metric-card-top">
                <span class="metric-label">STOCK-IN VALUE</span>
                <div class="metric-icon">
                    <i class="bi bi-box-arrow-in-down"></i>
                </div>
            </div>

            <h3 id="stockInValueDisplay">
                ₱ {{ number_format($stockInValue, 2) }}
            </h3>

            <span class="metric-caption period-caption">
                {{ $periodLabel ?? 'Last 30 days' }}
            </span>
        </div>
    </div>

    <!-- Stock-Out -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card report-metric-card metric-stock-out h-100">
            <div class="metric-card-top">
                <span class="metric-label">STOCK-OUT VALUE</span>
                <div class="metric-icon">
                    <i class="bi bi-box-arrow-up"></i>
                </div>
            </div>

            <h3 id="stockOutValueDisplay">
                ₱ {{ number_format($stockOutValue, 2) }}
            </h3>

            <span class="metric-caption period-caption">
                {{ $periodLabel ?? 'Last 30 days' }}
            </span>
        </div>
    </div>

    <!-- Purchase Requests -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card report-metric-card metric-purchase h-100">
            <div class="metric-card-top">
                <span class="metric-label">PURCHASE REQUESTS</span>
                <div class="metric-icon">
                    <i class="bi bi-clipboard-check"></i>
                </div>
            </div>

            <h3 id="purchaseRequestsDisplay">
                {{ $purchaseRequestsCount }}
            </h3>

            <span class="metric-caption">Awaiting review</span>
        </div>
    </div>

    <!-- Waste / Expired -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card report-metric-card metric-waste h-100">
            <div class="metric-card-top">
                <span class="metric-label">WASTE / EXPIRED</span>
                <div class="metric-icon">
                    <i class="bi bi-trash3"></i>
                </div>
            </div>

            <h3 id="wasteExpiredDisplay">
                ₱ {{ number_format($wasteExpiredValue ?? 0, 2) }}
            </h3>

            <span class="metric-caption">Recorded losses</span>
        </div>
    </div>

</div>


            <!-- Charts & Category Section -->
            <div class="row g-4">
                <!-- Stock Movement Chart -->
                <div class="col-lg-8">
                    <div class="card p-4 bg-white h-100">
                        <h5 class="fw-bold text-dark">Stock movement</h5>
                        <p class="text-muted small">Monthly incoming vs outgoing quantities (Last 6 months)</p>

                        <div style="height: 280px; position: relative;">
                            <canvas id="stockMovementChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- By Category Breakdown -->
                <div class="col-lg-4">
                    <div class="card p-4 bg-white h-100">
                        <h5 class="fw-bold text-dark mb-4">By category</h5>
                        <div id="categorySummaryContainer">
                            @php
                                $maxCategoryVal = max($categorySummaries->pluck('total_value')->toArray() ?: [1]);
                            @endphp
                            @forelse($categorySummaries as $cat)
                                @php
                                    $barWidth = $maxCategoryVal > 0 ? min(100, round(($cat->total_value / $maxCategoryVal) * 100)) : 100;
                                @endphp
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small fw-bold text-dark mb-1">
                                        <span>{{ $cat->category_name }}</span>
                                        <span>{{ number_format($cat->total_value) }} units</span>
                                    </div>
                                    <div class="progress" style="height: 8px; background-color: #e9ecef;">
                                    <div class="progress-bar" style="width: {{ $barWidth }}%; background-color: #107c57;" role="progressbar"></div>                                    </div>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
        <script>
        let chartLabels = @json($stockMovementLabels);
        let stockInValues = @json($stockInData);
        let stockOutValues = @json($stockOutData);
        let categorySummariesData = @json($categorySummaries);

        let reportSummaryData = {
            stockInValue: @json(number_format($stockInValue, 2)),
            stockOutValue: @json(number_format($stockOutValue, 2)),
            purchaseRequestsCount: @json($purchaseRequestsCount),
            wasteExpiredValue: @json(number_format($wasteExpiredValue ?? 0, 2)),
            stockInQuantity: @json($stockInQuantity ?? 0),
            stockOutQuantity: @json($stockOutQuantity ?? 0)
        };

        const ctx = document.getElementById('stockMovementChart');

        const stockMovementChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'Stock-In',
                        data: [...stockInValues],
                        backgroundColor: '#107c57',
                        borderRadius: 5
                    },
                    {
                        label: 'Stock-Out',
                        data: [...stockOutValues],
                        backgroundColor: '#e09b36',
                        borderRadius: 5
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Quantity'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    }
                }
            }
        });

        function renderCategoriesUI(categories) {
            const container = document.getElementById('categorySummaryContainer');
            if (!container) return;

            if (!categories || categories.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-tags fs-2 text-secondary opacity-50"></i>
                        <p class="small mb-0 mt-2">No category inventory found.</p>
                    </div>
                `;
                return;
            }

            const maxVal = Math.max(...categories.map(c => Number(c.total_value ?? 0)), 1);

            container.innerHTML = categories.map(cat => {
                const val = Number(cat.total_value ?? 0);
                const widthPct = Math.min(100, Math.round((val / maxVal) * 100));
                const safeName = String(cat.category_name ?? 'Uncategorized')
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;');

                return `
                    <div class="mb-3">
                        <div class="d-flex justify-content-between small fw-bold text-dark mb-1">
                            <span>${safeName}</span>
                            <span>${val.toLocaleString()} units</span>
                        </div>
                        <div class="progress" style="height: 8px; background-color: #e9ecef;">
                            <div class="progress-bar" style="width: ${widthPct}%; background-color: #107c57;"></div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        async function generateReport() {
            const btn = document.getElementById('generateReportBtn');
            const period = document.getElementById('periodFilter').value;
            const category = document.getElementById('categoryFilter').value;
            const txType = document.getElementById('transactionTypeFilter').value;
            const statusBadge = document.getElementById('reportStatusText');

            const originalHtml = btn ? btn.innerHTML : '';
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Generating...';
            }

            try {
                const params = new URLSearchParams({
                    period: period,
                    category: category,
                    transaction_type: txType
                });

                const response = await fetch(`{{ route('reports.generate') }}?${params.toString()}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    const errText = await response.text();
                    throw new Error(`HTTP ${response.status}: ${errText.slice(0, 120)}`);
                }

                const data = await response.json();

                document.getElementById('stockInValueDisplay').textContent = '₱ ' + data.summary.stockInValueFormatted;
                document.getElementById('stockOutValueDisplay').textContent = '₱ ' + data.summary.stockOutValueFormatted;
                document.getElementById('purchaseRequestsDisplay').textContent = data.summary.purchaseRequestsCount;
                document.getElementById('wasteExpiredDisplay').textContent = '₱ ' + data.summary.wasteExpiredFormatted;

                document.querySelectorAll('.period-caption').forEach(el => {
                    el.textContent = data.summary.periodLabel;
                });

                reportSummaryData = {
                    stockInValue: data.summary.stockInValueFormatted,
                    stockOutValue: data.summary.stockOutValueFormatted,
                    purchaseRequestsCount: data.summary.purchaseRequestsCount,
                    wasteExpiredValue: data.summary.wasteExpiredFormatted,
                    stockInQuantity: data.summary.stockInQuantity,
                    stockOutQuantity: data.summary.stockOutQuantity
                };

                chartLabels = data.chart.labels;
                stockInValues = data.chart.stockInData;
                stockOutValues = data.chart.stockOutData;
                categorySummariesData = data.categories;

                stockMovementChart.data.labels = chartLabels;
                stockMovementChart.data.datasets[0].data = [...stockInValues];
                stockMovementChart.data.datasets[1].data = [...stockOutValues];
                stockMovementChart.data.datasets[0].hidden = (txType === 'stock-out');
                stockMovementChart.data.datasets[1].hidden = (txType === 'stock-in');
                stockMovementChart.update();

                renderCategoriesUI(categorySummariesData);

                if (statusBadge) {
                    const catLabel = category === 'all' ? 'All categories' : category;
                    statusBadge.textContent = `Generated: ${data.summary.periodLabel} • ${catLabel}`;
                }
            } catch (error) {
                console.error('Generate Report Error:', error);
                alert('Could not generate report: ' + error.message);
            } finally {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = originalHtml;
                }
            }
        }

        function exportInventoryReportPDF() {
            try {
                if (!window.jspdf || !window.jspdf.jsPDF) {
                    throw new Error('jsPDF library failed to load.');
                }

                const { jsPDF } = window.jspdf;
                const doc = new jsPDF({
                    orientation: 'portrait',
                    unit: 'mm',
                    format: 'a4'
                });

                const period = document.getElementById('periodFilter').value;
                const category = document.getElementById('categoryFilter').value;
                const txType = document.getElementById('transactionTypeFilter').value;

                doc.setFillColor(17, 30, 46);
                doc.rect(0, 0, 210, 32, 'F');

                doc.setTextColor(255, 255, 255);
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(18);
                doc.text('StockPilot - Inventory Report', 14, 15);

                doc.setFont('helvetica', 'normal');
                doc.setFontSize(9.5);
                doc.text(
                    `Generated: ${new Date().toLocaleDateString()}   |   Period: ${period}   |   Category: ${category === 'all' ? 'All categories' : category}`,
                    14,
                    24
                );

                doc.setTextColor(17, 24, 39);
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(12);
                doc.text('1. Executive Summary', 14, 43);

                doc.autoTable({
                    startY: 47,
                    head: [['Metric', 'Value', 'Notes']],
                    body: [
                        ['Stock-In Value', 'PHP ' + reportSummaryData.stockInValue, `${reportSummaryData.stockInQuantity} units received (${period})`],
                        ['Stock-Out Value', 'PHP ' + reportSummaryData.stockOutValue, `${reportSummaryData.stockOutQuantity} units issued (${period})`],
                        ['Pending Purchase Requests', String(reportSummaryData.purchaseRequestsCount), 'Awaiting manager review'],
                        ['Waste / Expired Losses', 'PHP ' + reportSummaryData.wasteExpiredValue, 'Expired ingredient valuation']
                    ],
                    theme: 'grid',
                    headStyles: { fillColor: [16, 124, 87], textColor: 255, fontStyle: 'bold' },
                    styles: { fontSize: 9.5, cellPadding: 3 }
                });

                let nextY = doc.lastAutoTable.finalY + 10;
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(12);
                doc.text('2. Monthly Stock Movement (Last 6 Months)', 14, nextY);

                const movementRows = chartLabels.map((label, idx) => [
                    label,
                    txType === 'stock-out' ? '—' : Number(stockInValues[idx] ?? 0).toLocaleString(),
                    txType === 'stock-in' ? '—' : Number(stockOutValues[idx] ?? 0).toLocaleString()
                ]);

                doc.autoTable({
                    startY: nextY + 4,
                    head: [['Month', 'Stock-In Quantity', 'Stock-Out Quantity']],
                    body: movementRows,
                    theme: 'grid',
                    headStyles: { fillColor: [31, 61, 69], textColor: 255, fontStyle: 'bold' },
                    styles: { fontSize: 9.5, cellPadding: 3 }
                });

                nextY = doc.lastAutoTable.finalY + 10;
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(12);
                doc.text('3. Inventory Breakdown by Category', 14, nextY);

                const categoryRows = (categorySummariesData && categorySummariesData.length > 0)
                    ? categorySummariesData.map(c => [
                        c.category_name ?? 'Uncategorized',
                        Number(c.total_value ?? 0).toLocaleString() + ' units'
                    ])
                    : [['No category inventory found', '0 units']];

                doc.autoTable({
                    startY: nextY + 4,
                    head: [['Category', 'Total Quantity']],
                    body: categoryRows,
                    theme: 'grid',
                    headStyles: { fillColor: [16, 124, 87], textColor: 255, fontStyle: 'bold' },
                    styles: { fontSize: 9.5, cellPadding: 3 }
                });

                const pageCount = doc.internal.getNumberOfPages();
                for (let i = 1; i <= pageCount; i++) {
                    doc.setPage(i);
                    doc.setFontSize(8);
                    doc.setTextColor(107, 114, 128);
                    doc.text(
                        `StockPilot Restaurant Inventory System  •  Page ${i} of ${pageCount}`,
                        105,
                        288,
                        { align: 'center' }
                    );
                }

                doc.save('stockpilot-inventory-report-' + new Date().toISOString().slice(0, 10) + '.pdf');
            } catch (error) {
                console.error('Report PDF Export Error:', error);
                alert('Unable to export report PDF: ' + error.message);
            }
        }
    </script>
</body>
</html>