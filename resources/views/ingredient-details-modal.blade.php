
<!-- INGREDIENT DETAILS MODAL -->
<div class="modal fade" id="ingredientDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content ingredient-modal">

            <!-- HEADER -->
            <div class="modal-header ingredient-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="modal-header-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>

                    <h5 class="modal-title fw-bold mb-0">
                        Ingredient Details
                    </h5>
                </div>

                <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body p-4">

                <!-- INGREDIENT NAME AND STATUS -->
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                    <div>
                        <h3 class="fw-bold mb-1" id="modalIngredientName">
                            Ingredient Name
                        </h3>

                        <span class="text-secondary" id="modalIngredientCategory">
                            Category
                        </span>
                    </div>

                    <span id="modalIngredientStatus" class="status">
                        Status
                    </span>

                </div>

                <!-- STOCK INFORMATION -->
                <div class="row g-0 ingredient-info-row">

                    <div class="col-md-6 ingredient-info-item">
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-box-seam info-icon"></i>

                            <div>
                                <small class="text-secondary">Current Stock</small>
                                <h4 class="fw-bold mb-0" id="modalIngredientQuantity">
                                    -
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 ingredient-info-item">
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-exclamation-triangle info-icon warning-icon"></i>

                            <div>
                                <small class="text-secondary">Minimum Stock</small>
                                <h4 class="fw-bold mb-0" id="modalIngredientMinimum">
                                    -
                                </h4>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- GENERAL INFORMATION -->
                <div class="row g-0 ingredient-info-row">

                    <div class="col-md-6 ingredient-info-item">
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-calendar-event info-icon"></i>

                            <div>
                                <small class="text-secondary">Expiration Date</small>
                                <p class="fw-semibold mb-0" id="modalIngredientExpiration">
                                    -
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 ingredient-info-item">
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-truck info-icon"></i>

                            <div>
                                <small class="text-secondary">Supplier</small>
                                <p class="fw-semibold mb-0" id="modalIngredientSupplier">
                                    -
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- NOTES -->
                <div class="ingredient-notes mt-4">
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-card-text info-icon"></i>

                        <div>
                            <small class="text-secondary fw-semibold">Additional Notes</small>
                            <p class="mb-0 mt-1" id="modalIngredientNotes">
                                No additional notes.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer ingredient-modal-footer">
                <button type="button" class="btn btn-green px-4"
                        data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>

<style>

    /* EXPIRED STATUS */
    .ingredient-modal .status-expired {
        background-color: #fee2e2;
        color: #b91c1c;
        border: 1px solid #dc2626;
        font-weight: 700;
    }

    /* MODAL DESIGN */
    .ingredient-modal {
        border: none;
        border-radius: 16px;
        overflow: hidden;
    }

    .ingredient-modal-header {
        padding: 20px 28px;
        border-bottom: 1px solid #e2e8f0;
    }

    .modal-header-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e8f5ee;
        color: #146c43;
        border-radius: 10px;
        font-size: 1.3rem;
    }

    .ingredient-modal .modal-title {
        font-size: 1.2rem;
        color: #1e293b;
    }

    .ingredient-modal .modal-body {
        color: #1e293b;
    }

    .ingredient-modal .modal-body h3 {
        font-size: 1.5rem;
    }

    .ingredient-modal .modal-body small {
        font-size: 0.82rem;
    }

    .ingredient-info-row {
        border-bottom: 1px solid #e2e8f0;
    }

    .ingredient-info-item {
        padding: 22px 16px;
    }

    .ingredient-info-item:nth-child(2) {
        border-left: 1px solid #e2e8f0;
    }

    .info-icon {
        color: #146c43;
        font-size: 1.7rem;
    }

    .warning-icon {
        color: #ea580c;
    }

    .ingredient-info-item h4 {
        font-size: 1.35rem;
        margin-top: 4px;
    }

    .ingredient-info-item p {
        font-size: 0.95rem;
        margin-top: 5px;
    }

    .ingredient-notes {
        background: #f1f5f9;
        border-radius: 12px;
        padding: 16px;
    }

    .ingredient-modal-footer {
        padding: 16px 28px;
        border-top: 1px solid #e2e8f0;
    }

    /* BLURRED BACKGROUND */
    .modal-backdrop.show {
        opacity: 1;
        background-color: rgba(15, 23, 42, 0.45);
    }

    /* MOBILE RESPONSIVENESS */
    @media (max-width: 576px) {
        .ingredient-modal-header {
            padding: 16px;
        }

        .ingredient-modal .modal-body {
            padding: 20px !important;
        }

        .ingredient-info-item {
            padding: 16px 8px;
        }

        .ingredient-info-item:nth-child(2) {
            border-left: none;
        }

        .ingredient-modal-footer {
            padding: 14px 20px;
        }
    }
</style>
