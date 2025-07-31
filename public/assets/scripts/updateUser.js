const updateBtn = document.getElementById("editInformation");
const inputs = document.querySelectorAll('input');
const btn = document.getElementById('editDescription');
const textarea = document.getElementById('description');
const formDescription = document.getElementById('formDescription');
let editing = false;


updateBtn.addEventListener('click', (event) => {
    event.preventDefault();

      if(!editing) {

        editing= true;
        updateBtn.classList.remove("btn-primary");
        updateBtn.classList.add("btn-secondary");
        inputs.forEach(input => {
        input.removeAttribute('readonly');
        input.classList.remove('bg-gris');
          
    })

    } else {
        
        formInformation.requestSubmit();
        
        }
    });

    formInformation.addEventListener('submit', (event) => {
            event.preventDefault(); 
            confirm('Etes vous sur de valider vos modifications?');
            formInformation.submit();
            console.log('Informations soumises');
     });


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
