const btn = document.getElementById('editDescription');
const textarea = document.getElementById('description');
const formDescription = document.getElementById('formDescription');
let editing = false;

btn.addEventListener('click', (event) => {
        event.preventDefault();

        if (!editing) {
            
            editing = true;
            btn.textContent = "Confirmez les modifications";
            btn.classList.remove("btn-primary");
            btn.classList.add("btn-secondary");
            textarea.removeAttribute('readonly');
            textarea.classList.remove('bg-gris');
            
        } else {

            formDescription.requestSubmit(); 
        }
    });

    formDescription.addEventListener('submit', (event) => {

        event.preventDefault(); 
        confirm('Etes vous sur de valider vos modifications?');
        formDescription.submit();
        console.log('Description soumise');
    });
