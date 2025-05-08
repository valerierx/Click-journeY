function lirecookie(name) { //lecture du cookie
        let cookies = document.cookie.split("; "); // en crée un tableau avec tout les cookie de la page
        for (let i = 0; i < cookies.length; i++) {
            let elem = cookies[i].split("="); // création de sous tableau [cle, valeur]
            let cle = elem[0];
            let valeur = elem[1];

            if (cle === name) { 
                return valeur; // on renvoi la valeur si c'est la bonne clé
            }
        }
        return null;
}


function changerTheme() {
    const link = document.getElementById("css");
    const btn = document.getElementById("Theme-bouton");

    const Theme_actuel = link.getAttribute("href").includes("sombre") ? "sombre" : "style"; // Si le href du fichier CSS contient sombre on considère que le theme actuel est sombre
    const nouvTheme = Theme_actuel === "sombre" ? "style" : "sombre"; // Si le theme actuel est sombre alors on passe au clair et inversement

    link.href = nouvTheme + ".css";
    document.cookie = "theme=" + nouvTheme + "; path=/; max-age=600"; //création du cookie
    btn.textContent = nouvTheme === "sombre" ? "☀️" : "🌙"; // mise a jour de l'affichage du bouton
}

const themeInitial = lirecookie("theme") || "style"; //si lire cookie renvoie null clair (style.css) par défaut
document.getElementById("Theme-bouton").textContent = themeInitial === "style" ? "☀️" : "🌙"; //affichage du bon emojis dans le bouton