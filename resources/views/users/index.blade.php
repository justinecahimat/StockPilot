<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockPilot - User Management</title>
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
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <span class="text-muted small">Workspace / User Management</span>
                    <h1 class="h3 fw-bold text-dark mt-1">User Management</h1>
                    <p class="text-muted mb-0">Manage system users, roles, and access credentials.</p>
                </div>
                <button class="btn btn-success px-4" style="background-color: #107c57;" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="bi bi-plus-lg me-1"></i> Add new user
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Users Table Card -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">

            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 px-4">NAME</th>
                        <th class="py-3">EMAIL</th>
                        <th class="py-3">ROLE</th>
                        <th class="py-3">STATUS</th>
                        <th class="py-3">CREATED AT</th>
                        <th class="py-3 text-end px-4">ACTIONS</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="px-4 fw-bold text-dark">
                                {{ $user->name }}
                            </td>

                            <td>
                                {{ $user->email }}
                            </td>

                            <td>
                                <span class="badge {{ strtolower($user->role ?? 'staff') == 'admin' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $user->role ?? 'Staff' }}
                                </span>
                            </td>

                            <td>
                                @if($user->status === 'pending')
                                    <span class="badge bg-warning text-dark">
                                        Pending
                                    </span>
                                @elseif($user->status === 'approved')
                                    <span class="badge bg-success">
                                        Approved
                                    </span>
                                @elseif($user->status === 'rejected')
                                    <span class="badge bg-danger">
                                        Rejected
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        {{ ucfirst($user->status ?? 'Unknown') }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $user->created_at->format('M d, Y') }}
                            </td>

                            <td class="text-end px-4">
                                @if(strtolower($user->role ?? 'staff') === 'staff' && $user->status === 'pending')

                                    <div class="d-flex justify-content-end gap-2">


                                    <form id="approve-form-{{ $user->id }}"
                                        action="{{ route('users.approve', $user->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <button type="button"
                                                class="btn btn-sm btn-success"
                                                data-confirm-form="approve-form-{{ $user->id }}"
                                                data-confirm-title="Approve Staff Account"
                                                data-confirm-message="Are you sure you want to approve {{ $user->name }}?"
                                                data-confirm-button="Approve"
                                                data-confirm-class="btn-success">
                                            <i class="bi bi-check-lg"></i>
                                            Approve
                                        </button>
                                    </form>


                                    <form id="reject-form-{{ $user->id }}"
                                        action="{{ route('users.reject', $user->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                data-confirm-form="reject-form-{{ $user->id }}"
                                                data-confirm-title="Reject Staff Registration"
                                                data-confirm-message="Are you sure you want to reject {{ $user->name }}'s registration?"
                                                data-confirm-button="Reject"
                                                data-confirm-class="btn-danger">
                                            <i class="bi bi-x-lg"></i>
                                            Reject
                                        </button>
                                    </form>

                                    </div>

                                @else


                                <form id="delete-form-{{ $user->id }}"
                                    action="{{ route('users.destroy', $user->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            data-confirm-form="delete-form-{{ $user->id }}"
                                            data-confirm-title="Delete User"
                                            data-confirm-message="Are you sure you want to delete {{ $user->name }}? This action cannot be undone."
                                            data-confirm-button="Delete"
                                            data-confirm-class="btn-danger">
                                        <i class="bi bi-trash"></i>
                                        Delete
                                    </button>
                                </form>

                                @endif
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                No users found in the system.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
                </div>
            </div>
            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold" id="addUserModalLabel">Add New System User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Full Name</label>
                            <input type="text" name="name" class="form-control" required placeholder="Enter full name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Email Address</label>
                            <input type="email" name="email" class="form-control" required placeholder="Enter email address">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Password</label>
                            <input type="password" name="password" class="form-control" required placeholder="Enter password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Role</label>
                            <select name="role" class="form-select">
                                <option value="Staff">Staff</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success px-4" style="background-color: #107c57;">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- StockPilot Confirmation Modal -->
    <div class="modal fade" id="actionConfirmModal" tabindex="-1"
        aria-labelledby="actionConfirmModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="actionConfirmModalLabel">
                        Confirm Action
                    </h5>

                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="d-flex align-items-start gap-3">

                        <div class="rounded-circle bg-light p-3">
                            <i class="bi bi-exclamation-triangle text-warning fs-4"></i>
                        </div>

                        <div>
                            <p class="mb-1 fw-semibold" id="confirmActionMessage">
                                Are you sure you want to continue?
                            </p>

                            <small class="text-muted">
                                Please confirm this action before proceeding.
                            </small>
                        </div>

                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="button"
                            class="btn btn-danger"
                            id="confirmActionButton">
                        Confirm
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalElement = document.getElementById('actionConfirmModal');

        if (!modalElement) return;

        const modal = new bootstrap.Modal(modalElement);

        const modalTitle = document.getElementById('actionConfirmModalLabel');
        const modalMessage = document.getElementById('confirmActionMessage');
        const confirmButton = document.getElementById('confirmActionButton');

        let selectedForm = null;

        document.addEventListener('click', function (event) {
            const button = event.target.closest('[data-confirm-form]');

            if (!button) return;

            const formId = button.dataset.confirmForm;
            selectedForm = document.getElementById(formId);

            if (!selectedForm) {
                console.error('Confirmation form not found:', formId);
                return;
            }

            modalTitle.textContent = button.dataset.confirmTitle || 'Confirm Action';
            modalMessage.textContent = button.dataset.confirmMessage || 'Are you sure?';
            confirmButton.textContent = button.dataset.confirmButton || 'Confirm';

            confirmButton.className = 'btn ' +
                (button.dataset.confirmClass || 'btn-danger');

            modal.show();
        });

        confirmButton.addEventListener('click', function () {
            if (selectedForm) {
                selectedForm.requestSubmit();
            }
        });

        modalElement.addEventListener('hidden.bs.modal', function () {
            selectedForm = null;
        });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
