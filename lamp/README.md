## Lancement site


# Installation de podman et de podman-compose
Ouvrez un terminal linux.
Sur Debian: sudo apt install podman podman-compose

# Téléchargement des conteneurs

Exécutez: podman-compose pull

# Lancement des conteneurs

Exécutez: podman-compose up -d

Lors du premier lancement, l'image podman PHP est crée à partir de l'image php-fpm, avec la compilation du plugin mysqli.

# Importation de la base de données

Rendez-vous sur PHPMyAdmin (adresse http://localhost:8081), cliquez sur Importer. Uploadez le fichier clickjourney.sql et appuyez sur Valider

# Ouverture du site

Le site sera joignable à l'adresse http://localhost:8080