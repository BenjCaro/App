const updateBtn = document.getElementById("editInformation");
const formInformation = document.getElementById('formInformation');
const formDescription = document.getElementById('formDescription');
const inputs = formInformation.querySelectorAll('input');
const btn = document.getElementById('editDescription');
const textarea = document.getElementById('description');
let editingInfos = false;
let editingDescription = false;

updateBtn.addEventListener('click', (event) => {
    event.preventDefault();

      if(!editingInfos) {

        editingInfos= true;
        updateBtn.textContent = "Confirmez les modifications";
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
           if(confirm('Etes vous sur de valider vos modifications?')) {

                formInformation.submit();

           } else {

              editingInfos = false;
              updateBtn.textContent = "Modifier ma description";
              updateBtn.classList.replace('btn-secondary', 'btn-primary');
              inputs.forEach(input => {
              input.setAttribute('readonly', true);
              input.classList.add('bg-gris');
          
        })
              
     }
            
            
     });


    btn.addEventListener('click', (event) => {
        event.preventDefault();

        if (!editingDescription) {
            
            editingDescription = true;
            btn.textContent = "Confirmez les modifications";
            btn.classList.replace('btn-primary', 'btn-secondary');
            textarea.removeAttribute('readonly');
            textarea.classList.remove('bg-gris');
            
        } else {

            formDescription.requestSubmit(); 
        }
    });

   formDescription.addEventListener('submit', (event) => {
    event.preventDefault();

    if (confirm('Êtes-vous sûr de valider vos modifications ?')) {
        formDescription.submit();
       

    } else {

        editingDescription = false; 
        btn.textContent = "Modifier ma description";
        btn.classList.replace('btn-secondary', 'btn-primary');
        textarea.setAttribute('readonly', true);
        textarea.classList.add('bg-gris');
    }
});

        