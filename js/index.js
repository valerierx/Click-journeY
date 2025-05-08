function basculerMotdepasse() {
  const champ = document.getElementById('motdepasse'); //Champ du mdp
  const icone = document.querySelector('.bouton-motdepasse');//Icone à changer
  const estCache = champ.type === 'password';//Vérif si le mdp est caché

  champ.type = estCache ? 'text' : 'password';
  icone.textContent = estCache ? '🙃' : '👀';
}
function mettreAJourCompteur(nomID, compteurID) { //Competeur dynamique de caractères
  const input = document.getElementById(nomID);// Champ saisie
  const compteur = document.getElementById(compteurID);//Elmt du compteur
  const maxLength = input.maxLength;// Nbr de caractères Max

  input.addEventListener('input', () => {//Mise à jour du compteur
    const longueur = input.value.length;
    compteur.textContent = `${longueur} / ${maxLength} caractères`;
  });
}

function AdresseValide(email){
  const mail=/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;//Vérifie si c'est de la meme forme qu'un email
  return mail.test(email.trim());//Vérifie la validié de l'email
}

function Email(){//Fction Message d'erreur
  const mail=document.getElementById("email");
  const message=document.getElementById("erreur-email");

    mail.addEventListener("input",()=>{// A chaque modificationd de l'email
      
      console.log("Saisie détectée :",mail.value);
    if(mail.value===""){
      message.style.display="none";
    }
    else if(!AdresseValide(mail.value)){
      message.style.display= "block";
    }
  else{
    message.style.display="none";
  }
  });
}


function verifMdp() {//Vérification que le mdp et sa confirmation correspondent
  const motdepasse = document.getElementById("motdepasse");
  const confirmation = document.getElementById("confirmation-mdp");
  const messageErreur = document.getElementById("erreur-mdp");
  const formulaire = document.querySelector("form");

  if (!motdepasse || !confirmation || !formulaire || !messageErreur) return;//Vérificaiton de l'existenec des elmts

  formulaire.addEventListener("submit", (val) => {
    if (motdepasse.value !== confirmation.value) {
      val.preventDefault(); //Empeche l'envoie du formulaire si les mdp sont différents
      messageErreur.style.display = "block";//Affiche le message d'erreur
    } else {
      messageErreur.style.display = "none"; //Cache l'erreur si pas de problèmes
    }
  });
}

window.addEventListener("load", () => {
  mettreAJourCompteur("email", "compteur-email");
  mettreAJourCompteur("motdepasse", "compteur-mdp");
  Email();
  verifMdp();
});
