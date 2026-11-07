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
                /* =========================================
                LOW-STOCK ALERTS PAGE
                ========================================= */

                /* MAIN LAYOUT */
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
                    background: #f4f7fa;
                    color: #1e293b;
                    font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
                    box-sizing: border-box;
                }

                /* Prevent sizing inconsistencies */
                .low-stock-page *,
                .low-stock-page *::before,
                .low-stock-page *::after {
                    box-sizing: border-box;
                }

                /* =========================================
                TOP NAVIGATION
                ========================================= */

                .low-stock-page .topbar {
                    height: 72px;
                    min-height: 72px;
                    background: #ffffff;
                    border-bottom: 1px solid #e2e8f0;

                    display: flex;
                    align-items: center;
                    justify-content: space-between;

                    padding: 0 32px;
                }

                .low-stock-page .topbar-left .breadcrumb {
                    font-size: 11px;
                    color: #64748b;
                    margin-bottom: 3px;
                }

                .low-stock-page .breadcrumb span {
                    margin: 0 5px;
                    color: #94a3b8;
                }

                .low-stock-page .topbar-left h2 {
                    font-size: 17px;
                    font-weight: 700;
                    margin: 0;
                    color: #1e293b;
                }

                .low-stock-page .topbar-right {
                    display: flex;
                    align-items: center;
                    gap: 24px;
                }

                .low-stock-page .search-box {
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

                .low-stock-page .search-box i {
                    font-size: 12px;
                    color: #64748b;
                }

                .low-stock-page .search-box input {
                    width: 100%;
                    border: none;
                    outline: none;
                    background: transparent;
                    font-size: 12px;
                    color: #1e293b;
                }

                .low-stock-page .admin-profile {
                    display: flex;
                    align-items: center;
                    gap: 9px;
                }

                .low-stock-page .admin-avatar {
                    width: 30px;
                    height: 30px;
                    border-radius: 50%;
                    background: #dff3e9;
                    color: #16734f;

                    display: flex;
                    align-items: center;
                    justify-content: center;

                    font-size: 10px;
                    font-weight: 700;
                }

                .low-stock-page .admin-info {
                    display: flex;
                    flex-direction: column;
                    gap: 2px;
                }

                .low-stock-page .admin-info strong {
                    font-size: 11px;
                    color: #1e293b;
                }

                .low-stock-page .admin-info small {
                    font-size: 9px;
                    color: #64748b;
                }

                /* =========================================
                PAGE CONTENT
                ========================================= */

                .low-stock-page .low-stock-content {
                    padding: 26px 32px;
                }

                .low-stock-page .page-heading {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    gap: 15px;
                    margin-bottom: 22px;
                }

                .low-stock-page .page-heading h1 {
                    font-size: 24px;
                    font-weight: 750;
                    margin: 0 0 5px;
                    color: #1e293b;
                }

                .low-stock-page .page-heading p {
                    font-size: 12px;
                    color: #64748b;
                    margin: 0;
                }

                .low-stock-page .heading-actions {
                    display: flex;
                    gap: 9px;
                }

                .low-stock-page .heading-actions button {
                    height: 37px;
                    padding: 0 15px;
                    border-radius: 6px;
                    font-size: 11px;
                    font-weight: 600;
                    cursor: pointer;
                    transition: background 0.2s ease;
                }

                .low-stock-page .btn-export {
                    background: #ffffff;
                    border: 1px solid #dbe3ed;
                    color: #1e293b;
                }

                .low-stock-page .btn-export:hover {
                    background: #f8fafc;
                }

                .low-stock-page .btn-create {
                    background: #167653;
                    border: 1px solid #167653;
                    color: #ffffff;
                }

                .low-stock-page .btn-create:hover {
                    background: #126044;
                }

                /* =========================================
                SUMMARY CARDS
                ========================================= */

                .low-stock-page .alert-summary {
                    display: grid;
                    grid-template-columns: repeat(4, minmax(0, 1fr));
                    gap: 14px;
                    margin-bottom: 20px;
                }

                .low-stock-page .summary-card {
                    background: #ffffff;
                    border: 1px solid #e2e8f0;
                    border-radius: 9px;
                    padding: 17px;
                    min-height: 112px;
                    box-shadow: 0 1px 2px rgba(15, 23, 42, 0.03);
                }

                .low-stock-page .summary-label {
                    display: block;
                    font-size: 10px;
                    font-weight: 700;
                    color: #64748b;
                    margin-bottom: 8px;
                    letter-spacing: 0.3px;
                }

                .low-stock-page .summary-card h2 {
                    font-size: 25px;
                    font-weight: 700;
                    margin: 0 0 5px;
                    color: #1e293b;
                }

                .low-stock-page .summary-card p {
                    font-size: 10px;
                    color: #64748b;
                    margin: 0;
                }

                /* =========================================
                ITEMS REQUIRING ATTENTION
                ========================================= */

                .low-stock-page .attention-section {
                    background: #ffffff;
                    border: 1px solid #e2e8f0;
                    border-radius: 9px;
                    padding: 20px;
                    box-shadow: 0 1px 2px rgba(15, 23, 42, 0.03);
                }

                .low-stock-page .attention-section h3 {
                    font-size: 15px;
                    font-weight: 700;
                    margin: 0 0 17px;
                    color: #1e293b;
                }

                .low-stock-page .table-container {
                    width: 100%;
                    overflow-x: auto;
                }

                .low-stock-page .alerts-table {
                    width: 100%;
                    border-collapse: collapse;
                    text-align: left;
                    white-space: nowrap;
                }

                .low-stock-page .alerts-table thead th {
                    font-size: 10px;
                    font-weight: 700;
                    color: #64748b;
                    padding: 13px 12px;
                    border-bottom: 1px solid #e2e8f0;
                    background: #f8fafc;
                }

                .low-stock-page .alerts-table tbody td {
                    font-size: 11px;
                    color: #475569;
                    padding: 16px 12px;
                    border-bottom: 1px solid #edf1f5;
                }

                .low-stock-page .alerts-table tbody tr:hover {
                    background: #f8fafc;
                }

                .low-stock-page .alerts-table tbody tr:last-child td {
                    border-bottom: none;
                }

                .low-stock-page .alerts-table .ingredient-name {
                    font-weight: 700;
                    color: #1e293b;
                }

                /* ALERT STATUS LABELS */

                .low-stock-page .status {
                    display: inline-block;
                    padding: 5px 9px;
                    border-radius: 20px;
                    font-size: 10px;
                    font-weight: 600;
                }

                .low-stock-page .status-critical {
                    background: #fee2e2;
                    color: #b91c1c;
                }

                .low-stock-page .status-low {
                    background: #fef3c7;
                    color: #92400e;
                }

                .low-stock-page .status-expiring {
                    background: #ffedd5;
                    color: #c2410c;
                }

                .low-stock-page .status-expired {
                    background: #f1f5f9;
                    color: #475569;
                }

                /* ACTION TEXT */

                .low-stock-page .action-text {
                    color: #167653;
                    font-weight: 600;
                    cursor: pointer;
                }

                .low-stock-page .action-text:hover {
                    text-decoration: underline;
                }

                /* =========================================
                RESPONSIVE DESIGN
                ========================================= */

                @media (max-width: 1100px) {
                    .low-stock-page .alert-summary {
                        grid-template-columns: repeat(2, minmax(0, 1fr));
                    }

                    .low-stock-page .low-stock-content {
                        padding: 22px 24px;
                    }
                }

                @media (max-width: 768px) {
                    .main-content.low-stock-page {
                        margin-left: 260px;
                    }

                    .low-stock-page .topbar {
                        padding: 0 20px;
                    }

                    .low-stock-page .topbar-right {
                        gap: 10px;
                    }

                    .low-stock-page .search-box {
                        display: none;
                    }

                    .low-stock-page .page-heading {
                        align-items: flex-start;
                        flex-direction: column;
                    }
                }

                @media (max-width: 600px) {
                    .low-stock-page .low-stock-content {
                        padding: 18px 14px;
                    }

                    .low-stock-page .heading-actions {
                        width: 100%;
                    }

                    .low-stock-page .heading-actions button {
                        flex: 1;
                    }

                    .low-stock-page .alert-summary {
                        grid-template-columns: repeat(2, minmax(0, 1fr));
                        gap: 9px;
                    }

                    .low-stock-page .summary-card {
                        padding: 13px;
                    }

                    .low-stock-page .attention-section {
                        padding: 15px 10px;
                    }
                }
                </style>

                <div class="low-stock-layout">

                    @include('sidebar')

                    <main class="main-content low-stock-page">

                        <!-- TOP NAVIGATION -->
                        <header class="topbar">

                            <div class="topbar-left">
                                <div class="breadcrumb">
                                    Workspace <span>/</span> Low-Stock Alerts
                                </div>

                                <h2>Low-Stock Alerts</h2>
                            </div>

                            <div class="topbar-right">

                                <div class="search-box">
                                    <i class="bi bi-search"></i>
                                    <input type="text" placeholder="Search anything...">
                                </div>

                                <div class="admin-profile">

                                    <div class="admin-avatar">AD</div>

                                    <div class="admin-info">
                                        <strong>Admin</strong>
                                        <small>Administrator</small>
                                    </div>

                                </div>

                            </div>

                        </header>

                        <!-- PAGE CONTENT -->
                        <div class="low-stock-content">

                            <!-- PAGE TITLE AND BUTTONS -->
                            <div class="page-heading">

                                <div>
                                    <h1>Low-Stock Alerts</h1>
                                    <p>Prioritize low quantities and ingredients nearing expiration.</p>
                                </div>

                                <div class="heading-actions">

                                    <button type="button" class="btn-export">
                                        Export alerts
                                    </button>

                                    <button type="button" 
                                            class="btn-create"
                                            

                                        <i class="fas fa-plus"></i>
                                        Create request
                                    </button>

                                </div>

                            </div>

                            <!-- SUMMARY CARDS -->
                            <section class="alert-summary">

                                <div class="summary-card">
                                    <span class="summary-label">CRITICAL</span>
                                    <h2>{{ str_pad($criticalIngredients->count(), 2,'0', STR_PAD_LEFT) }}</h2>
                                    <p>Below 25% of minimum</p>
                                </div>

                                <div class="summary-card">
                                    <span class="summary-label">LOW STOCK</span>
                                    <h2>{{ str_pad($lowStockIngredients->count(), 2, '0', STR_PAD_LEFT) }}</h2>
                                    <p>Replenishment recommended</p>
                                </div>

                                <div class="summary-card">
                                    <span class="summary-label">EXPIRING SOON</span>
                                    <h2>{{ str_pad($expiringIngredients->count(), 2, '0', STR_PAD_LEFT) }}</h2>
                                    <p>Next 7 days</p>
                                </div>

                                <div class="summary-card">
                                    <span class="summary-label">EXPIRED</span>
                                    <h2>{{ str_pad($expiredIngredients->count(), 2, '0', STR_PAD_LEFT) }}</h2>
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

                                            @forelse ($alerts as $ingredient)

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

                                                    <td class="action-text">
                                                        @if (in_array($ingredient->alert_status, ['Critical', 'Low Stock']))
                                                            Create request
                                                        @else
                                                            Review item
                                                        @endif
                                                    </td>
                                                </tr>

                                            @empty

                                                <tr>
                                                    <td colspan="6" class="text-center py-4">
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

