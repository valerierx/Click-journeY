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
mettreAJourCompteur("email", "compteur-email");
mettreAJourCompteur("motdepasse", "compteur-mdp");
