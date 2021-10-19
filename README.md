# Groupe

- Hugo Fresnel
- Valentin Aubertin
- Léopold Le Nalinec
- Pierre-Alexandre Frisson

# Prérequis

Avant de pouvoir utilliser notre projet il faut mettre l'alias `covidciasie.com` dans votre fichier `/etc/hosts` afin de
rediriger ce domaine vers notre projet localement.

# Lancement

Pour lancer le projet il suffit de démarrer les services de docker via `sudo docker-compose up`.

Ainsi sont disponibles :

- Le projet en lui-même sur `covidciasie:8080`
- La gestion de la base de données avec phpmyadmin sur `localhost:3000` (en dev: USER=root, PASSWORD=root)