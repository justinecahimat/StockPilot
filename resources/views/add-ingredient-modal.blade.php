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