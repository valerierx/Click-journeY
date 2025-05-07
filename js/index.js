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

  mettreAJourCompteur("email", "compteur-email");
  mettreAJourCompteur("motdepasse", "compteur-mdp");
  Email();

