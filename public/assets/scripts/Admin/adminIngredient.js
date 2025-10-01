const updateForm = document.getElementById("updateForm");

    document.querySelectorAll('[data-bs-target="#hiddenForm"]').forEach(btn => {
        btn.addEventListener('click', () => {
            updateForm.querySelector('input[name="id"]').value = btn.dataset.id;
            updateForm.querySelector('input[name="name"]').value = btn.dataset.name;
            updateForm.querySelector('input[name="type"]').value = btn.dataset.type;
            });
    });

    const deleteForm = document.getElementById("deleteForm");

    document.querySelectorAll('[data-bs-target="#hiddenDeleteForm"]').forEach(btn => {
        btn.addEventListener('click', () => {
            deleteForm.querySelector('input[name="id"').value = btn.dataset.id;
        });
    });
    