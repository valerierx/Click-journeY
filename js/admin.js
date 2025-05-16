function formDataToJSON(formData) {
    if (!(formData instanceof FormData)) {
        throw TypeError('formData argument is not an instance of FormData');
    }

    const data = {}
    for (const [name, value] of formData) {
        data[name] = value;
    }

    return JSON.stringify(data);
}

async function getCommandes() {
    let response = await fetch('/api/admin/commandes.php', { method: 'GET' });

    if(response.ok) {
        return await response.json();
    } else {
        return [];
    }
}

function getOptions(paye) {
    switch (paye) {
        case 0:
            return `
                <option value="0" selected="selected">En attente</option>
                <option value="1">Confirmée</option>
                <option value="2">Annulée</option>
            `;
        case 1:
            return `
                <option value="0">En attente</option>
                <option value="1" selected="selected">Confirmée</option>
                <option value="2">Annulée</option>
            `;
        case 2:
            return `
                <option value="0">En attente</option>
                <option value="1">Confirmée</option>
                <option value="2" selected="selected">Annulée</option>
            `;
        default:
            return '';
    }
}


// POPULATE commandes

getCommandes().then((commandes) => {
    commandes.forEach((commande) => {
        let ligne = document.createElement('tr');
        ligne.innerHTML = `<tr>
            <td>${commande.id}</td>
            <td>${commande.titre}</td>
            <td>${commande.compte.prenom}</td>
            <td>${commande.compte.nom}</td>
            <td>${commande.debut}</td>
            <td>${commande.compte.id}</td>
            <td><select class="status" data-id="${commande.id}">
                ${getOptions(commande.paye)}
            </select></td>
            </tr>`;

        document.getElementById('tablecommandes').appendChild(ligne);
    })

    // MODIFICATION commandes
    let selecteur = document.getElementsByClassName("status");
    let modif = document.getElementById("modifResa");

    for (let i = 0; i < selecteur.length; i++) {
        selecteur[i].onchange = function () {
            console.log(selecteur[i].options[selecteur[i].selectedIndex].hasAttribute("selected"))
            if (selecteur[i].options[selecteur[i].selectedIndex].hasAttribute("selected")) {
                selecteur[i].className = "status";
            } else {
                selecteur[i].className = "status modif";
            }
        }
    }

    modif.onclick = async function () {
        let json = [];
        let selecteurMod = document.getElementsByClassName("status modif");
        for (let i = 0; i < selecteurMod.length; i++) {
            json.push({"id": selecteurMod[i].dataset.id, "paye": selecteurMod[i].options[selecteurMod[i].selectedIndex].value})
        }
        console.log(JSON.stringify(json));
        if (json.length > 0) {
            let response = await fetch("/api/admin/commandes.php", {
                method: 'POST',
                body: JSON.stringify(json),
            })

            let result = await response.json();
            if (response.ok) {
                let valide = document.createElement("p");
                valide.className = "message valide";
                valide.textContent = "Succès !";
                document.getElementById("msgcommandes").appendChild(valide);
            } else {
                let erreur = document.createElement("p");
                erreur.className = "message erreur";
                erreur.textContent = result.message + " : " + result.status_code + " " + result.message;
                document.getElementById("msgcommandes").appendChild(erreur);
            }
        }
    }
})







/*
    messages = document.querySelectorAll(".message");
    if(messages.length > 0) {
        messages.forEach(message => message.remove());
    }
    if(bouton.type === "button") {
        e.preventDefault();
        bouton.type = "submit";
    }
    formulaire = document.querySelector("form");
    document.querySelectorAll("input:disabled").forEach(champ => {
        champ.toggleAttribute('disabled');
    });
    bouton.textContent = "Valider la modification";
    formulaire.onsubmit = async (e) => {
        e.preventDefault();
        const formData = formDataToJSON(new FormData(formulaire))
        let response = await fetch('/api/profil.php', {
            method: 'POST',
            body: formData,
        });
        let result = await response.json();
        if(response.ok) {
            let valide = document.createElement("p");
            valide.className = "message valide";
            valide.textContent = "Votre profil a été modifié!";
            formulaire.parentNode.insertBefore(valide, formulaire);
            bouton.textContent = "Modifier le profil";
            bouton.type = "button";
            document.querySelectorAll("input").forEach(champ => {
                champ.toggleAttribute('disabled');
            });
        } else {
            let erreur = document.createElement("p");
            erreur.className = "message erreur";
            erreur.textContent = result.message + " : " + result.status_code + " " + result.message;
            formulaire.parentNode.insertBefore(erreur, formulaire);
        }
    };


}
*/