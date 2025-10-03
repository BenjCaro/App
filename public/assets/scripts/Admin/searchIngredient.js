const searchIngredient = document.getElementById("searchBtn");

searchIngredient.addEventListener("click", async () => {
    const query = document.getElementById("searchInput").value.trim();
    
    if (!query) return;

    try {
        const response = await fetch(`/admin/ingredients/search?q=${encodeURIComponent(query)}`);
        const data = await response.json();

        const resultsTable = document.getElementById("results");
        resultsTable.innerHTML = ""; 

        if (data.length === 0) {
            resultsTable.innerHTML = "<p>Aucun résultat trouvé.</p>";
            return;
        }

        const table = document.createElement("table");
        table.className = "table table-bordered table-hover";

        const thead = document.createElement("thead");
        thead.className = "table-secondary";
        thead.innerHTML = `
            <tr>
                <th>Nom</th>
                <th>Type</th>
                <th colspan="2">Actions</th>
            </tr>
        `;
        table.appendChild(thead);

        const tbody = document.createElement("tbody");

        data.forEach(item => {
            const row = document.createElement("tr");

            const tdName = document.createElement("td");
            tdName.textContent = item.name;
            row.appendChild(tdName);

            const tdType = document.createElement("td");
            tdType.textContent = item.type;
            row.appendChild(tdType);

            const tdEdit = document.createElement("td");
            tdEdit.innerHTML = `
                <button type="button" class="btn btn-primary" 
                    data-bs-toggle="modal" data-bs-target="#hiddenForm"
                    data-id="${item.id}" data-name="${item.name}" data-type="${item.type}">
                    Modifier
                </button>
            `;
            row.appendChild(tdEdit);

            const tdDelete = document.createElement("td");
            tdDelete.innerHTML = `
                <button class="btn btn-orange" 
                    data-bs-toggle="modal" data-bs-target="#hiddenDeleteForm" 
                    data-id="${item.id}">
                    Supprimer
                </button>
            `;
            row.appendChild(tdDelete);

            tbody.appendChild(row);
        });

        table.appendChild(tbody);
        resultsTable.appendChild(table);

    } catch (err) {
        console.error("Erreur :", err);
    }
});
