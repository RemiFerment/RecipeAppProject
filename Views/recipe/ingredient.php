<template id="ingredient-template">
    <div class="prefab-ingredient d-flex align-items-center my-2">
        <input type="text" name="ingredient[]" placeholder="Nom" class="form-control me-2 flex-grow-1" style="min-width:0; flex-basis:75%;" required>
        <input type="text" name="amount[]" placeholder="Quantité" class="form-control me-2" style="width: 25%;" required>
        <select name="unit[]" class="form-select me-2" style="width: 25%;">
            <option value="1">Unité</option>
            <option value="2">mL</option>
            <option value="3">g</option>
            <option value="4">CàS</option>
            <option value="5">CàC</option>
            <option value="6">Pincé</option>
        </select>
        <input type="button" value="-" class="removeButton btn btn-danger">
    </div>
</template>