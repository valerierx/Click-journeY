function basculerMotdepasse() {
  const champ = document.getElementById('motdepasse');
  const icone = document.querySelector('.bouton-motdepasse');
  const estCache = champ.type === 'password';

  champ.type = estCache ? 'text' : 'password';
  icone.textContent = estCache ? '🙃' : '👀';
}
function mettreAJourCompteur(nomID, compteurID) {
  const input = document.getElementById(nomID);
  const compteur = document.getElementById(compteurID);
  const maxLength = input.maxLength;

  input.addEventListener('input', () => {
    const longueur = input.value.length;
    compteur.textContent = `${longueur} / ${maxLength} caractères`;
  });
}

function AdresseValide(email){
  const mail=/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  return mail.test(email.trim());
}

function Email(){
  const mail=document.getElementById("email");
  const message=document.getElementById("erreur-email");

    mail.addEventListener("input",()=>{
      
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


function verifMdp() {
  const motdepasse = document.getElementById("motdepasse");
  const confirmation = document.getElementById("confirmation-mdp");
  const messageErreur = document.getElementById("erreur-mdp");
  const formulaire = document.querySelector("form");

  if (!motdepasse || !confirmation || !formulaire || !messageErreur) return;

  formulaire.addEventListener("submit", (val) => {
    if (motdepasse.value !== confirmation.value) {
      val.preventDefault(); 
      messageErreur.style.display = "block";
    } else {
      messageErreur.style.display = "none";
    }
  });
}

window.addEventListener("load", () => {
  mettreAJourCompteur("email", "compteur-email");
  mettreAJourCompteur("motdepasse", "compteur-mdp");
  Email();
  verifMdp();
});
