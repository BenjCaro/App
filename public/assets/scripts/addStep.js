function addStep() {
    const container = document.getElementById('description-container');

    const div = document.createElement('div');
    div.classList.add('d-flex', 'flex-column', 'mb-2', 'gap-2', 'justify-content-center');
    
    const text = document.createElement('textarea');
    text.classList.add('form-control');
    text.name = 'description[]';
    text.placeholder = "Ajouter une nouvelle étape";

    const btn = document.createElement('button');
    btn.type = 'button';
    btn.textContent = 'Supprimer';
    btn.classList.add('btn', 'btn-secondary', 'w-25');
    btn.onclick = () => div.remove();

    div.appendChild(text);
    div.appendChild(btn);

    container.appendChild(div);
    
    }