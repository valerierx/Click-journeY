## Lancement site


# Installation de podman et de podman-compose
- Sous Ubuntu > 22.04 et Debian >= 12.10:
	
```bash
sudo apt install -y podman podman-compose
```

- Pour toute version d'Ubuntu antèrieure, il faudra installer le paquet podman depuis un dépot tiers.
```bash
sudo add-apt-repository -y ppa:quarckster/containers
sudo apt install -y podman
```

Pour l'installation de podman-compose, téléchargez le manuellement:

```bash
sudo curl -o /usr/local/bin/podman-compose https://raw.githubusercontent.com/containers/podman-compose/main/podman_compose.py
sudo chmod +x /usr/local/bin/podman-compose
```

# Téléchargement des conteneurs

Exécutez: 
```bash=
sudo podman-compose pull
```

# Lancement des conteneurs

Exécutez: 
```bash
podman-compose up -d
```

Lors du premier lancement, l'image podman PHP est crée à partir de l'image php-fpm, avec la compilation du plugin mysqli.

# Importation de la base de données

Rendez-vous sur PHPMyAdmin (adresse http://localhost:8081), cliquez sur Importer. Uploadez le fichier clickjourney.sql et appuyez sur Valider

# Ouverture du site

Le site sera joignable à l'adresse [http://localhost:8080](http://localhost:8080), et PHPMyAdmin à [http://localhost:8081](http://localhost:8081)