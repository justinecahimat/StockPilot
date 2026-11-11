<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockPilot - Ingredients & Supplies</title>
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

        /* Table Customization */
        .table-custom th {
            font-weight: 600;
            font-size: 0.725rem;
            color: #64748b;
            letter-spacing: 0.5px;
            padding-bottom: 14px;
            border-bottom: 1px solid #e2e8f0;
        }

        .table-custom td {
            padding: 16px 12px;
            vertical-align: middle;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.875rem;
        }

        .ingredient-search-box {
            position: relative;
            width: 220px;
        }

        .ingredient-search-box i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 12px;
        }

        .ingredient-search-box input {
            width: 100%;
            height: 36px;
            padding: 0 12px 0 34px;
            border: 1px solid #d9e2ec;
            border-radius: 8px;
            background-color: #fff;
            color: #334155;
            font-size: 12px;
            outline: none;
        }

        .ingredient-search-box input::placeholder {
            color: #64748b;
            opacity: 1;
        }

        .ingredient-search-box input:focus {
            border-color: #a8bfd8;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.08);
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
                Workspace / <span class="text-dark fw-medium">Ingredients & Supplies</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="ingredient-search-box">
                    <i class="bi bi-search"></i>
                    <input
                        type="text"
                        id="ingredientSearch"
                        placeholder="Search by name or keyword"
                        autocomplete="off"
                    >
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

        <!-- Header & Action Buttons -->
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Ingredients & Supplies</h2>
                <p class="text-secondary mb-0" style="font-size: 0.9rem;">View, search, and maintain the restaurant's ingredient inventory.</p>
            </div>
            <div class="d-flex gap-2">
                <div class="dropdown">
                    <button type="button"
                            class="btn btn-outline-secondary bg-white shadow-sm px-3 fw-medium dropdown-toggle"
                            style="font-size: 0.875rem;"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">

                        <i class="bi bi-download me-1"></i>
                        Export

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">

                        <li>
                            <a class="dropdown-item"
                            href="{{ route('ingredients.export-csv', request()->query()) }}">

                                <i class="bi bi-file-earmark-spreadsheet me-2 text-success"></i>
                                Export as CSV

                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                            href="javascript:void(0);"
                            onclick="exportIngredientsPDF()">
                                <i class="bi bi-file-earmark-pdf me-2 text-danger"></i>
                                Export as PDF
                            </a>
                        </li>

                    </ul>
                </div>
                <button class="btn btn-green shadow-sm px-3" data-bs-toggle="modal" data-bs-target="#addIngredientModal">+ Add ingredient</button>
            </div>
        </div>

        <!-- Filter Bar Card -->
        <div class="card border-0 shadow-sm rounded-4 p-3 mb-4">
            <form action="{{ route('ingredients.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-5">
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control ps-5 bg-light border-0" placeholder="Search by name or keyword">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select bg-light border-0 text-secondary">
                        <option value="">All categories</option>
                        @foreach($categories as $cat)
                            @if($cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select bg-light border-0 text-secondary">
                        <option>All status</option>
                        <option>In Stock</option>
                        <option>Low Stock</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-green w-100 shadow-sm">Apply filters</button>
                </div>
            </form>
        </div>

        <!-- Data Table Card -->
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="table-responsive">
                <table id="ingredientsTable" class="table table-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th>INGREDIENT</th>
                            <th>CATEGORY</th>
                            <th>QUANTITY</th>
                            <th>MIN. STOCK</th>
                            <th>SUPPLIER</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ingredients as $item)
                            <tr class="ingredient-row">
                                <td class="fw-semibold">
                                    <a href="{{ route('ingredients.show', $item->id) }}"
                                    class="text-dark text-decoration-none">
                                        {{ $item->name }}
                                    </a>
                                </td>
                                <td>{{ $item->category ?? 'N/A' }}</td>
                                <td>{{ $item->quantity }} {{ $item->unit }}</td>
                                <td>{{ $item->min_quantity }}</td>
                                <td>{{ $item->supplier ?? 'N/A' }}</td>
                                <td>
                                    @if($item->quantity <= $item->min_quantity)
                                        <span class="text-danger fw-medium">Low Stock</span>
                                    @else
                                        <span class="text-secondary">In Stock</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                        <tr class="empty-table-row">
                                <td colspan="6" class="text-center text-secondary py-5">No ingredients found. Click "+ Add new" to add one!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                <div class="text-secondary" style="font-size: 0.85rem;">
                    Showing records {{ $ingredients->firstItem() ?? 0 }}–{{ $ingredients->lastItem() ?? 0 }} of {{ $ingredients->total() }}
                </div>
                <div>
                    {{ $ingredients->links() }}
                </div>
            </div>
        </div>
    </main>
</div>

@include('add-ingredient-modal')

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- jsPDF Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<!-- jsPDF AutoTable Plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>


<script>
        async function exportIngredientsPDF() {

            try {
                // Retrieve all matching ingredients from Laravel
                const response = await fetch(
                    @json(route('ingredients.export-pdf', request()->query())),
                    {
                        headers: {
                            'Accept': 'application/json'
                        }
                    }
                );

                if (!response.ok) {
                    throw new Error('Unable to retrieve ingredient records.');
                }

                const ingredients = await response.json();

                // Check PDF libraries
                if (!window.jspdf || !window.jspdf.jsPDF) {
                    throw new Error('jsPDF library could not load.');
                }

                const { jsPDF } = window.jspdf;

                // Create landscape A4 PDF
                const doc = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: 'a4'
                });

                // Report title
                doc.setFontSize(18);
                doc.setFont('helvetica', 'bold');
                doc.text('StockPilot - Ingredients & Supplies', 14, 18);

                // Report information
                doc.setFontSize(10);
                doc.setFont('helvetica', 'normal');
                doc.text('Inventory Report', 14, 25);
                doc.text('Generated: ' + new Date().toLocaleDateString(), 14, 31);
                doc.text('Total Records: ' + ingredients.length, 14, 37);

                // Prepare table data
                const rows = ingredients.map(item => {

                    const status = Number(item.quantity) <= Number(item.min_quantity)
                        ? 'Low Stock'
                        : 'In Stock';

                    return [
                        item.name ?? 'N/A',
                        item.category ?? 'N/A',
                        item.quantity ?? 0,
                        item.unit ?? 'N/A',
                        item.min_quantity ?? 0,
                        item.supplier ?? 'N/A',
                        status
                    ];
                });

                // Generate table
                doc.autoTable({
                    startY: 44,

                    head: [[
                        'Ingredient',
                        'Category',
                        'Quantity',
                        'Unit',
                        'Minimum Stock',
                        'Supplier',
                        'Status'
                    ]],

                    body: rows,

                    theme: 'grid',

                    styles: {
                        fontSize: 9,
                        cellPadding: 3,
                        valign: 'middle'
                    },

                    headStyles: {
                        fillColor: [31, 61, 69],
                        textColor: 255,
                        fontStyle: 'bold'
                    },

                    alternateRowStyles: {
                        fillColor: [245, 247, 249]
                    },

                    didParseCell: function(data) {

                        if (data.section === 'body' && data.column.index === 6) {

                            if (data.cell.raw === 'Low Stock') {
                                data.cell.styles.textColor = [220, 53, 69];
                                data.cell.styles.fontStyle = 'bold';
                            } else {
                                data.cell.styles.textColor = [25, 135, 84];
                            }
                        }
                    }
                });

                // Add page numbers
                const pageCount = doc.internal.getNumberOfPages();

                for (let i = 1; i <= pageCount; i++) {
                    doc.setPage(i);
                    doc.setFontSize(8);

                    doc.text(
                        'Page ' + i + ' of ' + pageCount,
                        doc.internal.pageSize.getWidth() - 14,
                        doc.internal.pageSize.getHeight() - 8,
                        { align: 'right' }
                    );
                }

                // Download PDF
                doc.save(
                    'stockpilot-ingredients-' +
                    new Date().toISOString().slice(0, 10) +
                    '.pdf'
                );

            } catch (error) {
                console.error('PDF Export Error:', error);
                alert('PDF export failed: ' + error.message);
            }
        }
        </script>



        <script>
        document.addEventListener('DOMContentLoaded', function () {

            const searchInput = document.getElementById('ingredientSearch');
            const ingredientsTable = document.getElementById('ingredientsTable');

            if (!searchInput || !ingredientsTable) {
                return;
            }

            const ingredientRows = ingredientsTable.querySelectorAll('.ingredient-row');
            const emptyRow = ingredientsTable.querySelector('.empty-table-row');

            let noResultsRow = document.getElementById('noSearchResults');

            if (!noResultsRow) {
                noResultsRow = document.createElement('tr');
                noResultsRow.id = 'noSearchResults';
                noResultsRow.style.display = 'none';

                noResultsRow.innerHTML = `
                    <td colspan="6" class="text-center text-secondary py-5">
                        No matching ingredients found.
                    </td>
                `;

                ingredientsTable.querySelector('tbody').appendChild(noResultsRow);
            }

            searchInput.addEventListener('input', function () {

                const searchValue = this.value.toLowerCase().trim();
                let visibleCount = 0;

                ingredientRows.forEach(function (row) {

                    const rowText = row.textContent.toLowerCase();
                    const matches = rowText.includes(searchValue);

                    row.style.display = matches ? '' : 'none';

                    if (matches) {
                        visibleCount++;
                    }

                });

                if (ingredientRows.length === 0) {
                    if (emptyRow) {
                        emptyRow.style.display = '';
                    }

                    noResultsRow.style.display = 'none';
                } else {
                    if (emptyRow) {
                        emptyRow.style.display = 'none';
                    }

                    noResultsRow.style.display =
                        visibleCount === 0 ? '' : 'none';
                }
            });

        });
        </script>
</body>
</html>