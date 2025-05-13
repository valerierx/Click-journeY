const params = new URLSearchParams(window.location.search);
const voyageId = parseInt(params.get("get"));

const form = document.getElementById("voyageForm");
const prixDisplay = document.getElementById("prixTotal");

if (voyageId) {
    loadEtapes(voyageId);
} else {
    form.innerHTML = "<p style='color:red;'>Aucun ID de voyage fourni.</p>";
}

async function loadEtapes(id) {
    try {
        const res = await fetch(`api/options.php?id=${id}`);
        if (!res.ok) throw new Error("Erreur de chargement.");
        const etapes = await res.json();
        console.log(etapes)
        renderForm(etapes);
    } catch (e) {
        form.innerHTML = `<p style="color:red;">${e.message}</p>`;
    }
}

function renderForm(etapes) {
    form.innerHTML = "";

    // Looping through the etapes object using for...in
    for (const key in etapes) {
        const etape = etapes[key]; // Accessing each etape object
        const fieldset = document.createElement("fieldset");
        const legend = document.createElement("legend");
        legend.textContent = etape.titre;
        fieldset.appendChild(legend);

        if (!etape.options || etape.options.length === 0) {
            const p = document.createElement("p");
            p.textContent = "Aucune option disponible.";
            fieldset.appendChild(p);
        } else {
            // Loop through options for each etape
            for (let i = 0; i < etape.options.length; i++) {
                const option = etape.options[i];

                const wrapper = document.createElement("div");
                wrapper.className = "option-block";

                const label = document.createElement("label");
                label.textContent = `${option.titre} - ${option.prix} € / pers. (max ${option.personnesMax})`;

                const select = document.createElement("select");
                select.name = `option_${option.id}`;
                select.dataset.prix = option.prix;

                for (let j = 0; j <= option.personnesMax; j++) {
                    const opt = document.createElement("option");
                    opt.value = j;
                    opt.textContent = j;
                    select.appendChild(opt);
                }

                select.addEventListener("change", updatePrixTotal);

                wrapper.appendChild(label);
                wrapper.appendChild(select);
                fieldset.appendChild(wrapper);
            }
        }

        form.appendChild(fieldset);
    }

    updatePrixTotal(); // Initial update
}

function updatePrixTotal() {
    const selects = form.querySelectorAll("select");
    let total = 0;

    selects.forEach(select => {
        const prix = parseFloat(select.dataset.prix);
        const quantite = parseInt(select.value);
        total += prix * quantite;
    });

    prixDisplay.textContent = total;
}