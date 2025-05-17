let commandesData, tableCmds, triColCmds;
let triAscCmds = false;
const taillePage = 10;
let curPageCmd = 1;
tableCmds = document.getElementById('tablecommandes');
document.addEventListener('DOMContentLoaded', getCommandes, false);
resaPrec = document.querySelector('#resaPrec');
resaSuiv = document.querySelector('#resaSuiv')
resaPrec.addEventListener('click', pageResaPrec, false);
resaSuiv.addEventListener('click', pageResaSuiv, false);
let modif = document.getElementById("modifResa");
let tailleResaData = 0;
let maxPageCmd = 0;
msgCommandes = document.getElementById("msgcommandes");

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
        commandesData = await response.json();
        tailleResaData = commandesData.length - 1;
        maxPageCmd = Math.ceil(commandesData.length/taillePage)
        populateCommandes();

        document.querySelectorAll('#reservation thead tr th[data-tri]').forEach(t => {
            t.addEventListener('click', sort, false);
        });



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

function pageResaPrec() {
    if(curPageCmd > 1) curPageCmd--;
    populateCommandes();
}

function pageResaSuiv() {
    if((curPageCmd * taillePage) < commandesData.length) curPageCmd++;
    populateCommandes();
}


// POPULATE commandes


function sort(e) {
    let thisTri = e.target.dataset.tri;
    document.querySelectorAll('#reservation thead tr th[data-tri]').forEach(t => {
        t.removeAttribute("aria-sort");
    });

    if(triColCmds === thisTri) {
        triAscCmds = !triAscCmds
    }
    triColCmds = thisTri;
    if(triAscCmds) {
        e.target.setAttribute("aria-sort", "ascending");
    } else {
        e.target.setAttribute("aria-sort", "descending");
    }
    if(triColCmds === "idCompte") {
        commandesData.sort((a, b) => {
            if(a["compte"]["id"] < b["compte"]["id"]) return triAscCmds?1:-1;
            if(a["compte"]["id"] > b["compte"]["id"]) return triAscCmds?-1:1;
            return 0;
        });
    } else {
        commandesData.sort((a, b) => {
            if(a[triColCmds] < b[triColCmds]) return triAscCmds?1:-1;
            if(a[triColCmds] > b[triColCmds]) return triAscCmds?-1:1;
            return 0;
        });
    }

    populateCommandes();
}

function populateCommandes() {
    let debutInPage = false;
    let finInPage = false;
    let commandesResult = ""
    console.log(tailleResaData);
    commandesData.filter((ligne, index) => {
        let debut = (curPageCmd-1)*taillePage;
        let fin = curPageCmd*taillePage;
        if(index >= debut && index < fin) {
            if(index === 0) {
                debutInPage = true;
            }
            if(index === tailleResaData) {
                finInPage = true;
            }
            return true;
        }
    }).forEach((commande) => {
        commandesResult += `<tr>
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
    })

    tableCmds.innerHTML = commandesResult;
    if(debutInPage && finInPage) {
        resaPrec.setAttribute('disabled', '');
        resaSuiv.setAttribute('disabled', '');
    } else if(debutInPage) {
        resaPrec.setAttribute('disabled', '');
        resaSuiv.removeAttribute('disabled');
    } else if(finInPage) {
        resaPrec.removeAttribute('disabled');
        resaSuiv.setAttribute('disabled', '');
    } else {
        resaSuiv.removeAttribute('disabled');
        resaPrec.removeAttribute('disabled');
    }

    document.getElementById("resaPage").textContent = curPageCmd + "/" + maxPageCmd;


    // MODIFICATION commandes
    let selecteur = document.getElementsByClassName("status");

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
        msgCommandes.innerHTML = "";
        if (json.length > 0) {
            let attente = document.createElement("p");
            attente.className = "message attente";
            attente.textContent = "Chargement...";
            msgCommandes.appendChild(attente);

            let response = await fetch("/api/admin/commandes.php", {
                method: 'POST',
                body: JSON.stringify(json),
            })

            let result = await response.json();
            if (response.ok) {
                msgCommandes.innerHTML = "";
                let valide = document.createElement("p");
                valide.className = "message valide";
                valide.textContent = "Succès !";
                msgCommandes.appendChild(valide);
                populateCommandes();
            } else {
                msgCommandes.innerHTML = "";
                let erreur = document.createElement("p");
                erreur.className = "message erreur";
                erreur.textContent = result.message + " : " + result.status_code + " " + result.message;
                msgCommandes.appendChild(erreur);
            }
        } else {
            let erreur = document.createElement("p");
            erreur.className = "message erreur";
            erreur.textContent = "Veuillez modifier au moins un statut";
            msgCommandes.appendChild(erreur);
        }
    }
}








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