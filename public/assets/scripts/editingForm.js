/**
 * Active l’édition inline d’un formulaire avec boutons de modification et annulation.
 * 
 * @param {HTMLFormElement} form - Le formulaire HTML contenant les champs à éditer.
 * @param {HTMLElement[]} fields - Un tableau d’éléments HTML (inputs, textarea) à rendre éditables.
 * @param {HTMLButtonElement} button - Le bouton qui déclenche l’activation / validation des modifications.
 */


export function edit(form, fields, button) {
    let editing = false;
    let originalValues = fields.map(field => field.value);
   
    const cancelBtn = document.createElement('button');
    cancelBtn.classList.add('btn', 'btn-secondary');
    cancelBtn.type = "button";
    cancelBtn.textContent = "Annuler";
    cancelBtn.addEventListener('click', () => {
            editing = false;
            button.textContent = "Modifier mon commentaire";
            button.classList.replace("btn-secondary", "btn-primary");

            fields.forEach((field, index) => {
                field.value = originalValues[index];
                field.setAttribute("readonly", true);
                field.classList.add("bg-gris")
       });
            cancelBtn.remove();
         
       });

       button.addEventListener('click', (event) => {
        event.preventDefault();

        if(!editing){

          editing = true;
          button.textContent = "Confirmez les modifications";
          button.classList.replace("btn-primary", "btn-secondary");
          fields.forEach(field => {
             field.removeAttribute("readonly");
             field.classList.remove("bg-gris");
          });
          
         
         button.insertAdjacentElement('afterend', cancelBtn);


        } else {
            form.querySelector('#hiddenSubmit').click();

        }

       }); 

       form.addEventListener('submit', (event)=> {
           
           if(!confirm('Etes vous sur de valider vos modifications?')) {
                event.preventDefault();
                cancelBtn.click();
        } 
       });



}