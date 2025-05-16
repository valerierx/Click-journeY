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

bouton = document.getElementById("modif");

bouton.onclick = (e) => {
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
