const ingredientsContainer = document.querySelector('.ingredients');
const addButton = document.getElementById('add-button');
const ingredientTemplate = document.getElementById('ingredient-template');

addButton.addEventListener('click', () => {
    // 1. Clone le contenu du template
    const clone = ingredientTemplate.content.cloneNode(true);

    // 2. Trouve le bouton "-" dans le bloc cloné
    const removeButton = clone.querySelector('.removeButton');

    // 3. Ajoute l’event listener pour supprimer ce bloc
    removeButton.addEventListener('click', (event) => {
        event.target.closest('.prefab-ingredient').remove();
    });

    // 4. Insère le clone dans la div.ingredients
    ingredientsContainer.appendChild(clone);
});
