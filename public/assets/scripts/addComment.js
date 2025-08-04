const btnPost = document.getElementById('btnPost');
const container = document.getElementById('container');
btnPost.addEventListener('click', (event) => {

        if (container.querySelector('form')) return; // n'affiche qu'un seul formulaire 
       
        const form = document.createElement('form');
        form.classList.add('form-control', 'w-50', 'd-flex', 'flex-column', 'align-items-center', 'pb-2', 'border-gris', 'bg-gris','shadow-sm', 'p-3', 'mb-5', 'bg-body-gris');
        form.method = "post";
        form.action = `/recette/${slug}/commentaires`;


        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'title';
        input.required = true;
        input.classList.add('form-control', 'mb-2');
        input.placeholder = 'Titre de votre commentaire';

        const textarea = document.createElement('textarea');
        textarea.classList.add('form-control', 'mb-2');
        textarea.name = 'content';
        textarea.required = true;

        const submitBtn = document.createElement('button');
        submitBtn.classList.add('btn', 'btn-primary');
        submitBtn.type = 'submit';
        submitBtn.textContent = 'Poster votre commentaire';

        const cancelBtn = document.createElement('button');
        cancelBtn.classList.add('btn', 'btn-secondary');
        cancelBtn.type = 'button'; // important pour ne pas envoyer le formulaire
        cancelBtn.textContent = 'Annuler';
        cancelBtn.addEventListener('click', () => {
            form.remove(); // Supprime le formulaire du DOM
        });

        const btnContainer = document.createElement('div');
        btnContainer.classList.add('d-flex', 'justify-content-center', 'gap-2');
        btnContainer.appendChild(submitBtn);
        btnContainer.appendChild(cancelBtn);

        form.appendChild(input);
        form.appendChild(textarea);
        form.appendChild(btnContainer);
        container.appendChild(form);
    
 });