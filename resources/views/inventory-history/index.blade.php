<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockPilot - Inventory History</title>
    <!-- Bootstrap CSS & Icons -->
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
    </style>
</head>
<body>

    <!-- Include Sidebar -->
    @if(view()->exists('layouts.sidebar'))
        @include('layouts.sidebar')
    @else
        @include('sidebar')
    @endif

    <!-- Main Content Area -->
    <div class="main-content">
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 fw-bold text-dark">Inventory History</h1>
                    <p class="text-muted">Review stock-in and stock-out activity with user and date details.</p>
                </div>
            </div>

            <!-- Filter Card -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body">
                    <form method="GET" action="{{ route('inventory.history') }}" class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Search by ingredient name" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-dark w-100">Apply filters</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table Section (Demonstrating Multi-Entity Joins) -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <table