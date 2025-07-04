<template id="ingredient-template">
    <div class="prefab-ingredient d-flex align-items-center my-2">
        <input type="text" name="ingredient[]" placeholder="Nom" class="form-control me-2 flex-grow-1" style="min-width:0; flex-basis:75%;" required>
        <input type="text" name="amount[]" placeholder="Quantité" class="form-control me-2" style="width: 25%;" required>
        <select name="unit[]" class="form-select me-2" style="width: 25%;">
            <option value="Unite">Unité</option>
            <option value="mL">mL</option>
            <option value="g">g</option>
            <option value="CaS">CàS</option>
            <option value="CaC">CàC</option>
            <option value="Pince">Pincé</option>
        </select>
        <input type="button" value="-" class="removeButton btn btn-danger">
    </div>
</template>