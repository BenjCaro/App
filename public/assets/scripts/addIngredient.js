   function addIngredient() {
        const container = document.getElementById('ingredients-container');

        const div = document.createElement('div');
        div.classList.add('d-flex', 'mb-2', 'gap-2', 'align-items-center');

        // Select d'ingrédients
        const select = document.createElement('select');
        select.name = 'ingredients[]';
        select.classList.add('form-select');
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.disabled = true;
        defaultOption.selected = true;
        defaultOption.textContent = 'Choisir un ingrédient';
        select.appendChild(defaultOption);

        ingredientsData.forEach(ing => {
            const option = document.createElement('option');
            option.value = ing.id;
            option.textContent = ing.name;
            select.appendChild(option);
        });

        // Input quantité
        const input = document.createElement('input');
        input.name = 'quantites[]';
        input.type = 'text';
        input.placeholder = 'Quantité';
        input.classList.add('form-control');

        // Input Unité

        const unit = document.createElement('input');
        unit.name = 'unit[]';
        unit.type = 'text';
        unit.placeholder = 'Unité';
        unit.classList.add('form-control');

        // Bouton suppression
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.textContent = 'Supprimer';
        btn.classList.add('btn', 'btn-secondary');
        btn.onclick = () => div.remove();

        div.appendChild(select);
        div.appendChild(input);
        div.appendChild(unit);
        div.appendChild(btn);

        container.appendChild(div);
    }
