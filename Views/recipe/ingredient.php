<template id="ingredient-template">
    <div class="prefab-ingredient">
        <input type="text" name="ingredient[]" placeholder="Nom" required>
        <input type="text" name="amount[]" placeholder="Quantité" required>
        <select name="unit[]">
            <option value="Unite">Unité</option>
            <option value="mL">mL</option>
            <option value="g">g</option>
            <option value="CaS">CàS</option>
            <option value="CaC">CàC</option>
            <option value="Pince">Pincé</option>
        </select>
        <input type="button" value="-" class="removeButton">
        <br> <br>
    </div>
</template>