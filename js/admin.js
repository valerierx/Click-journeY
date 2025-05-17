let commandesData, tableCmds, triColCmds, comptesData, tableComptes, triColComptes;
let triAscCmds = false;
let triAscComptes = false;
const taillePage = 10;
let curPageCmd = 1;
let curPageComptes = 1;

// tbody comptes et commandes
tableCmds = document.getElementById('tablecommandes');
tableComptes = document.getElementById('tablecomptes');

// register GET asynchrone
document.addEventListener('DOMContentLoaded', getCommandes, false);
document.addEventListener('DOMContentLoaded', getComptes, false);

// BOUTONS PRECEDENT/SUIVANT
resaPrec = document.querySelector('#resaPrec');
resaSuiv = document.querySelector('#resaSuiv');
comptesPrec = document.querySelector('#comptesPrec');
comptesSuiv = document.querySelector('#comptesSuiv');

// inscription event
resaPrec.addEventListener('click', pageResaPrec, false);
resaSuiv.addEventListener('click', pageResaSuiv, false);
comptesPrec.addEventListener('click', pageComptesPrec, false);
comptesSuiv.addEventListener('click', pageComptesSuiv, false);

let modif = document.getElementById("modifResa");
let modifComptes = document.getElementById("modifComptes");
let tailleComptes = 0;
let tailleResaData = 0;
let maxPageCmd = 0;
let maxPageCom = 0;
msgCommandes = document.getElementById("msgcommandes");
msgComptes = document.getElementById("msgcomptes");


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
            t.addEventListener('click', sortCmds, false);
        });



    } else {
        return [];
    }

}

async function getComptes() {
    let response = await fetch('/api/admin/comptes.php', { method: 'GET' });

    if(response.ok) {
        comptesData = await response.json();
        tailleComptes = comptesData.length - 1;
        maxPageCom = Math.ceil(comptesData.length/taillePage)
        populateComptes();

        document.querySelectorAll('#utilisateurs thead tr th[data-tri]').forEach(t => {
            t.addEventListener('click', sortComp, false);
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

function getRole(role) {
    switch (role) {
        case 0:
            return `
                <option value="0" selected="selected">Administrateur</option>
                <option value="1">Particulier</option>
                <option value="2">Entreprise</option>
            `;
        case 1:
            return `
                <option value="0">Administrateur</option>
                <option value="1" selected="selected">Particulier</option>
                <option value="2">Entreprise</option>
            `;
        case 2:
            return `
                <option value="0">Administrateur</option>
                <option value="1">Particulier</option>
                <option value="2" selected="selected">Entreprise</option>
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

function pageComptesPrec() {
    if(curPageComptes > 1) curPageComptes--;
    populateComptes();
}

function pageComptesSuiv() {
    if((curPageComptes * taillePage) < comptesData.length) curPageComptes++;
    populateComptes();
}


// POPULATE commandes


function sortCmds(e) {
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

function sortComp(e) {
    let thisTri= e.target.dataset.tri;
    document.querySelectorAll('#utilisateurs thead tr th[data-tri]').forEach(t => {
        t.removeAttribute("aria-sort");
    });

    if(triColComptes === thisTri) {
        triAscComptes = !triAscComptes
    }
    triColComptes = thisTri;
    if(triAscComptes) {
        e.target.setAttribute("aria-sort", "ascending");
    } else {
        e.target.setAttribute("aria-sort", "descending");
    }
    comptesData.sort((a, b) => {
        if(a[triColComptes] < b[triColComptes]) return triAscComptes?1:-1;
        if(a[triColComptes] > b[triColComptes]) return triAscComptes?-1:1;
        return 0;
    });

    populateComptes();
}

function populateComptes() {
    let debutInPage = false;
    let finInPage = false;
    let comptesResult = ""
    console.log(tailleComptes);
    comptesData.filter((ligne, index) => {
        let debut = (curPageComptes - 1) * taillePage;
        let fin = curPageComptes * taillePage;
        if (index >= debut && index < fin) {
            if (index === 0) {
                debutInPage = true;
            }
            if (index === tailleComptes) {
                finInPage = true;
            }
            return true;
        }
    }).forEach((compte) => {
        comptesResult += `<tr>
            <td>${compte.id}</td>
            <td>${compte.prenom}</td>
            <td>${compte.nom}</td>
            <td>${compte.mail}</td>
            <td>${compte.naissance}</td>
            <td><select class="role" data-id="${compte.id}">
                ${getRole(compte.role)}
            </select></td>
            </tr>`;
    })

    tableComptes.innerHTML = comptesResult;
    if (debutInPage && finInPage) {
        comptesPrec.setAttribute('disabled', '');
        comptesSuiv.setAttribute('disabled', '');
    } else if (debutInPage) {
        comptesPrec.setAttribute('disabled', '');
        comptesSuiv.removeAttribute('disabled');
    } else if (finInPage) {
        comptesPrec.removeAttribute('disabled');
        comptesSuiv.setAttribute('disabled', '');
    } else {
        comptesSuiv.removeAttribute('disabled');
        comptesPrec.removeAttribute('disabled');
    }

    document.getElementById("comptesPage").textContent = curPageComptes + "/" + maxPageCom;

    //Modif
    let selecteur = document.getElementsByClassName("role");

    for (let i = 0; i < selecteur.length; i++) {
        selecteur[i].onchange = function () {
            console.log(selecteur[i].options[selecteur[i].selectedIndex].hasAttribute("selected"))
            if (selecteur[i].options[selecteur[i].selectedIndex].hasAttribute("selected")) {
                selecteur[i].className = "role";
            } else {
                selecteur[i].className = "role modif";
            }
        }
    }

    modifComptes.onclick = async function () {
        let json = [];
        let selecteurMod = document.getElementsByClassName("role modif");
        for (let i = 0; i < selecteurMod.length; i++) {
            json.push({"id": selecteurMod[i].dataset.id, "role": selecteurMod[i].options[selecteurMod[i].selectedIndex].value})
        }
        msgComptes.innerHTML = "";
        if (json.length > 0) {
            let attente = document.createElement("p");
            attente.className = "message attente";
            attente.textContent = "Chargement...";
            msgComptes.appendChild(attente);

            let response = await fetch("/api/admin/comptes.php", {
                method: 'POST',
                body: JSON.stringify(json),
            })

            let result = await response.json();
            if (response.ok) {
                msgComptes.innerHTML = "";
                let valide = document.createElement("p");
                valide.className = "message valide";
                valide.textContent = "Succès !";
                msgComptes.appendChild(valide);
                populateComptes();
            } else {
                msgComptes.innerHTML = "";
                let erreur = document.createElement("p");
                erreur.className = "message erreur";
                erreur.textContent = result.message + " : " + result.status_code + " " + result.message;
                msgComptes.appendChild(erreur);
            }
        } else {
            let erreur = document.createElement("p");
            erreur.className = "message erreur";
            erreur.textContent = "Veuillez modifier au moins un statut";
            msgComptes.appendChild(erreur);
        }
    }
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