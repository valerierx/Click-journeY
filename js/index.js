function basculerMotdepasse() {
  const champ = document.getElementById('motdepasse');
  const icone = document.querySelector('.bouton-motdepasse');
  const estCache = champ.type === 'password';

  champ.type = estCache ? 'text' : 'password';
  icone.textContent = estCache ? '🙃' : '👀';
}