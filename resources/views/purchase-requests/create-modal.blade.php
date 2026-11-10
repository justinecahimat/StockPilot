
<!-- CREATE PURCHASE REQUEST MODAL -->
<div class="modal fade" id="createPurchaseRequestModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 rounded-4">

            <!-- MODAL HEADER -->
            <div class="modal-header px-4 py-3">
                <div>
                    <h5 class="modal-title fw-bold">Create Purchase Request</h5>
                    <small class="text-secondary">
                        Add the ingredients and quantities you want to request.
                    </small>
                </div>

                <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- MODAL BODY -->
            <div class="modal-body p-4">

                <form action="{{ route('purchase-request.store') }}"
                      method="POST"
                      id="purchaseRequestForm">

                    @csrf

                    <!-- REQUESTED ITEMS -->
                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h6 class="fw-bold mb-0">Requested Ingredients</h6>

                        <button type="button" class="btn btn-outline-success btn-sm"
                                id="addPurchaseItem">
                            <i class="bi bi-plus-lg me-1"></i>
                            Add Item
                        </button>

                    </div>

                    <!-- ITEMS CONTAINER -->
                    <div id="purchaseItemsContainer">

                        <div class="purchase-item-row border rounded-3 p-3 mb-3">

                            <div class="row g-3 align-items-end">

                                <!-- INGREDIENT -->
                                <div class="col-md-4">

                                    <label class="form-label fw-semibold">
                                        Ingredient
                                    </label>

                                    <select name="items[0][ingredient_id]"
                                            class="form-select ingredient-select"
                                            required>

                                        <option value="">Select ingredient</option>

                                        @foreach($ingredients as $ingredient)
                                            <option
                                                value="{{ $ingredient->id }}"
                                                data-stock="{{ $ingredient->quantity }}"
                                                data-unit="{{ $ingredient->unit }}"
                                            >
                                                {{ $ingredient->name }}
                                            </option>
                                        @endforeach

                                    </select>

                                    <small class="text-secondary current-stock">
                                        Current stock: —
                                    </small>

                                </div>

                                <!-- QUANTITY -->
                                <div class="col-md-2">

                                    <label class="form-label fw-semibold">
                                        Quantity
                                    </label>

                                    <input type="number"
                                           name="items[0][requested_quantity]"
                                           class="form-control requested-quantity"
                                           min="0.01"
                                           step="0.01"
                                           placeholder="0.00"
                                           required>

                                </div>

                                <!-- UNIT COST -->
                                <div class="col-md-2">

                                    <label class="form-label fw-semibold">
                                        Unit Cost (₱)
                                    </label>

                                    <input type="number"
                                           name="items[0][unit_cost]"
                                           class="form-control unit-cost"
                                           min="0"
                                           step="0.01"
                                           placeholder="0.00"
                                           required>

                                </div>

                                <!-- SUBTOTAL -->
                                <div class="col-md-3">

                                    <label class="form-label fw-semibold">
                                        Subtotal
                                    </label>

                                    <div class="form-control bg-light subtotal">
                                        ₱ 0.00
                                    </div>

                                </div>

                                <!-- REMOVE BUTTON -->
                                <div class="col-md-1">

                                    <button type="button"
                                            class="btn btn-outline-danger remove-item"
                                            disabled>
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- ESTIMATED TOTAL -->
                    <div class="d-flex justify-content-end mt-4">

                        <div class="text-end">

                            <div class="text-secondary small fw-semibold">
                                ESTIMATED TOTAL
                            </div>

                            <h3 class="fw-bold text-success mb-0"
                                id="purchaseGrandTotal">
                                ₱ 0.00
                            </h3>

                        </div>

                    </div>

                    <!-- FOOTER BUTTONS -->
                    <div class="d-flex justify-content-end gap-2 mt-4">

                        <button type="button"
                                class="btn btn-outline-secondary px-4"
                                data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit"
                                class="btn btn-success px-4">
                            <i class="bi bi-send me-1"></i>
                            Submit Request
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</div>


<!-- MODAL JAVASCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const container = document.getElementById('purchaseItemsContainer');
    const addButton = document.getElementById('addPurchaseItem');
    const grandTotal = document.getElementById('purchaseGrandTotal');

    let itemIndex = 1;

    // Format amounts into Philippine Peso
    function formatCurrency(amount) {
        return '₱ ' + amount.toLocaleString('en-PH', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Calculate subtotal and grand total
    function calculateTotal() {

        let total = 0;

        container.querySelectorAll('.purchase-item-row').forEach(row => {

            const quantity = parseFloat(
                row.querySelector('.requested-quantity').value
            ) || 0;

            const unitCost = parseFloat(
                row.querySelector('.unit-cost').value
            ) || 0;

            const subtotal = quantity * unitCost;

            row.querySelector('.subtotal').textContent =
                formatCurrency(subtotal);

            total += subtotal;

        });

        grandTotal.textContent = formatCurrency(total);
    }

    // Display the selected ingredient's current stock
    function updateStock(select) {

        const row = select.closest('.purchase-item-row');
        const selectedOption = select.options[select.selectedIndex];
        const stockDisplay = row.querySelector('.current-stock');

        if (!select.value) {
            stockDisplay.textContent = 'Current stock: —';
            return;
        }

        const stock = selectedOption.dataset.stock;
        const unit = selectedOption.dataset.unit || '';

        stockDisplay.textContent =
            'Current stock: ' + stock + ' ' + unit;
    }

    // Add a new ingredient row
    addButton.addEventListener('click', function () {

        const firstRow = container.querySelector('.purchase-item-row');
        const newRow = firstRow.cloneNode(true);

        // Update input names so each item has a unique index
        newRow.querySelectorAll('[name]').forEach(input => {

            input.name = input.name.replace(
                /\[\d+\]/,
                '[' + itemIndex + ']'
            );

        });

        // Reset the cloned fields
        newRow.querySelector('.ingredient-select').value = '';
        newRow.querySelector('.requested-quantity').value = '';
        newRow.querySelector('.unit-cost').value = '';

        newRow.querySelector('.current-stock').textContent =
            'Current stock: —';

        newRow.querySelector('.subtotal').textContent = '₱ 0.00';

        // Enable remove buttons
        container.querySelectorAll('.remove-item').forEach(button => {
            button.disabled = false;
        });

        container.appendChild(newRow);

        itemIndex++;

        calculateTotal();

    });

    // Listen for quantity, cost, and ingredient changes
    container.addEventListener('input', function (event) {

        if (
            event.target.classList.contains('requested-quantity') ||
            event.target.classList.contains('unit-cost')
        ) {
            calculateTotal();
        }

    });

    container.addEventListener('change', function (event) {

        if (event.target.classList.contains('ingredient-select')) {
            updateStock(event.target);
        }

    });

    // Remove an ingredient row
    container.addEventListener('click', function (event) {

        const removeButton = event.target.closest('.remove-item');

        if (!removeButton) return;

        const rows = container.querySelectorAll('.purchase-item-row');

        if (rows.length > 1) {

            removeButton.closest('.purchase-item-row').remove();

            if (container.querySelectorAll('.purchase-item-row').length === 1) {
                container.querySelector('.remove-item').disabled = true;
            }

            calculateTotal();

        }

    });

});
</script>
