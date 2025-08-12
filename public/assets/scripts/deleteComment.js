const formDelete = document.getElementById('formDelete');
    formDelete.addEventListener('submit', (event) => {
        event.preventDefault();
        if(confirm("Etes-vous sur de vouloir supprimer votre commentaire?")) {

            formDelete.submit();
        };
    });