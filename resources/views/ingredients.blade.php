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
        :root {
            --sidebar-bg: #111e2e;
            --sidebar-hover: #1c2d42;
            --sidebar-active: #1f3d45;
            --sidebar-active-border: #107c57;
            --primary-green: #107c57;
            --primary-green-hover: #0c6144;
            --light-bg: #f4f6f8;
        }

        body {
            background-color: var(--light-bg);
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            min-height: 100vh;
            color: #92a4b8;
        }

        .sidebar .brand-title {
            color: #ffffff;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .sidebar .brand-subtitle {
            font-size: 0.65rem;
            letter-spacing: 1px;
            color: #6c7d93;
        }

        .sidebar .section-label {
            font-size: 0.7rem;
            letter-spacing: 0.8px;
            color: #58697d;
            font-weight: 600;
        }

        .sidebar .nav-link {
            color: #8c9ba8;
            border-radius: 8px;
            padding: 9px 14px;
            font-size: 0.875rem;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: #ffffff;
        }

        .sidebar .nav-link.active {
            background-color: var(--sidebar-active);
            color: #ffffff;
            font-weight: 500;
            border-left: 3px solid var(--sidebar-active-border);
        }

        .main-content {
            flex: 1;
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
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <aside class="sidebar p-3 d-flex flex-column">
        <div class="mb-4 ps-2 pt-2">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-box-seam-fill text-success fs-4"></i>
                <div>
                    <div class="brand-title">StockPilot</div>
                    <div class="brand-subtitle">RESTAURANT INVENTORY SYSTEM</div>
                </div>
            </div>
        </div>

        <div class="section-label mb-2 ps-2">WORKSPACE</div>

        <nav class="nav flex-column mb-auto">
            <a href="{{ route('dashboard') }}" class="nav-link"><i class="bi bi-grid-fill"></i> Dashboard</a>
            <a href="{{ route('ingredients.index') }}" class="nav-link active"><i class="bi bi-box"></i> Ingredients & Supplies</a>
            <a href="{{ route('categories.index') }}" class="nav-link"><i class="bi bi-tags"></i> Categories</a>
            <a href="{{ route('stock-in.create') }}" class="nav-link"><i class="bi bi-arrow-down-left-square"></i> Stock-In</a>
            <a href="{{ route('suppliers.index') }}" class="nav-link"><i class="bi bi-truck"></i> Suppliers</a>
            <a href="{{ route('stock-out.create') }}" class="nav-link"><i class="bi bi-arrow-up-right-square"></i> Stock-Out</a>
            <a href="#" class="nav-link"><i class="bi bi-arrow-down-left-square"></i> Stock-In</a>
            <a href="#" class="nav-link"><i class="bi bi-arrow-up-right-square"></i> Stock-Out</a>
            <a href="#" class="nav-link"><i class="bi bi-exclamation-triangle"></i> Low-Stock Alerts</a>
            <hr class="border-secondary my-2">
            <a href="#" class="nav-link"><i class="bi bi-file-earmark-text"></i> Purchase Requests</a>
            <a href="#" class="nav-link"><i class="bi bi-clock-history"></i> Inventory History</a>
            <a href="#" class="nav-link"><i class="bi bi-bar-chart"></i> Reports</a>
            <a href="#" class="nav-link"><i class="bi bi-people"></i> User Management</a>
        </nav>

        <!-- Logout Section -->
        <div class="mt-3 pt-3 border-top border-secondary">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="#" onclick="this.closest('form').submit(); return false;" class="nav-link text-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="main-content">
        <!-- Top Navbar -->
        <header class="d-flex justify-content-between align-items-center mb-4">
            <div class="top-nav">
                Workspace / <span class="text-dark fw-medium">Ingredients & Supplies</span>
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

        <!-- Header & Action Buttons -->
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Ingredients & Supplies</h2>
                <p class="text-secondary mb-0" style="font-size: 0.9rem;">View, search, and maintain the restaurant's ingredient inventory.</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary bg-white shadow-sm px-3 fw-medium" style="font-size: 0.875rem;">Export</button>
                <button class="btn btn-green shadow-sm px-3" data-bs-toggle="modal" data-bs-target="#addIngredientModal">+ Add new</button>
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
                <table class="table table-custom align-middle mb-0">
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
                            <tr>
                                <td class="fw-semibold text-dark">{{ $item->name }}</td>
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
                            <tr>
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

<!-- Add Ingredient Modal -->
<div class="modal fade" id="addIngredientModal" tabindex="-1" aria-labelledby="addIngredientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow rounded-4 p-3">
            <form action="{{ route('ingredients.store') }}" method="POST">
                @csrf
                <div class="modal-header border-bottom-0 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-1" id="addIngredientModalLabel">Add New Ingredient</h5>
                        <p class="text-secondary mb-0" style="font-size: 0.8rem;">Register an ingredient or supply in the inventory.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body py-3" style="font-size: 0.875rem;">
                    <div class="mb-2">
                        <label class="form-label fw-medium text-dark mb-1">Ingredient Name *</label>
                        <input type="text" name="name" class="form-control bg-light border-0" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-medium text-dark mb-1">Category *</label>
                        <select name="category" class="form-select bg-light border-0 text-secondary" required>
                            <option value="" disabled selected></option>
                            <option value="Meat & poultry">Meat & poultry</option>
                            <option value="Oils & condiments">Oils & condiments</option>
                            <option value="Dairy">Dairy</option>
                            <option value="Canned goods">Canned goods</option>
                            <option value="Produce">Produce</option>
                            <option value="Dry goods">Dry goods</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-medium text-dark d-block mb-1">Unit of Measurement *</label>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <div class="form-check p-2 bg-light rounded-3">
                                    <input class="form-check-input ms-1" type="radio" name="unit" id="ing_unit1" value="Pieces (pcs)" checked>
                                    <label class="form-check-label ms-2 text-dark" for="ing_unit1" style="font-size: 0.8rem;">Pieces (pcs)</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check p-2 bg-light rounded-3">
                                    <input class="form-check-input ms-1" type="radio" name="unit" id="ing_unit2" value="Kilograms (kg)">
                                    <label class="form-check-label ms-2 text-dark" for="ing_unit2" style="font-size: 0.8rem;">Kilograms (kg)</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check p-2 bg-light rounded-3">
                                    <input class="form-check-input ms-1" type="radio" name="unit" id="ing_unit3" value="Grams (g)">
                                    <label class="form-check-label ms-2 text-dark" for="ing_unit3" style="font-size: 0.8rem;">Grams (g)</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check p-2 bg-light rounded-3">
                                    <input class="form-check-input ms-1" type="radio" name="unit" id="ing_unit4" value="Liters (L)">
                                    <label class="form-check-label ms-2 text-dark" for="ing_unit4" style="font-size: 0.8rem;">Liters (L)</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check p-2 bg-light rounded-3">
                                    <input class="form-check-input ms-1" type="radio" name="unit" id="ing_unit5" value="Milliliters (mL)">
                                    <label class="form-check-label ms-2 text-dark" for="ing_unit5" style="font-size: 0.8rem;">Milliliters (mL)</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check p-2 bg-light rounded-3">
                                    <input class="form-check-input ms-1" type="radio" name="unit" id="ing_unit6" value="Packs / Packages">
                                    <label class="form-check-label ms-2 text-dark" for="ing_unit6" style="font-size: 0.8rem;">Packs / Packages</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-dark mb-1">Initial Quantity *</label>
                            <input type="number" name="quantity" class="form-control bg-light border-0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-dark mb-1">Minimum Quantity *</label>
                            <input type="number" name="min_quantity" class="form-control bg-light border-0" required>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-medium text-dark mb-1">Supplier</label>
                        <select name="supplier" class="form-select bg-light border-0 text-secondary">
                            <option value="" selected></option>
                            <option value="FreshFarm Co.">FreshFarm Co.</option>
                            <option value="Golden Pantry">Golden Pantry</option>
                            <option value="Dairy Direct">Dairy Direct</option>
                            <option value="Roma Foods">Roma Foods</option>
                            <option value="Green Basket">Green Basket</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-medium text-dark mb-1">Expiration Date</label>
                        <input type="date" name="expiration_date" class="form-control bg-light border-0">
                    </div>

                    <div class="mb-1">
                        <label class="form-label fw-medium text-dark mb-1">Notes (optional)</label>
                        <textarea name="notes" class="form-control bg-light border-0" rows="2"></textarea>
                    </div>
                </div>

                <div class="modal-footer border-top-0 pt-0 pb-2">
                    <button type="button" class="btn btn-light px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-green px-4">Save Ingredient</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>