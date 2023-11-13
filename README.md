# Objectif #

Créer une interface d'administration easyadmin dans une infra docker et docker compose.
Pouvoir débug cette application via xdebug.
Vous avez le droit de vous faire aider par chat gpt, notamment pour comprendre ce que vous faites. Et débug les erreurs de type infra que vous aurez.
Vous avez le droit de vous inspirer de la local infra pour la partie docker.

En respectant donc la stack définie ci avant, vous devez
- créer la stack nginx/postgresql/php
- créer un nouveau projet symfony
- configurer xdebug
- ajouter les entités
  Une organisation contient plusieurs groupe
  Un groupe appartient à une seule organisation
  Un groupe contient plusieurs contenants
  Un contenant appartient à un groupe
  Un contenant est associé à 1 ou plusieurs contrats
  Un contrats est associé à 1 contenant et 1 sonde
  1 sonde est associée à 1 contrat
- créer les crud controller pour ajouter/modifier/supprimer ces entités
- ajouter des filtres à ces crud
- créer un filtre custom permettant d'afficher tous les contenants ayant au moins 1 contrat

# Liste des containers Docker #
- postgres;
- php;
- nginx;

# Installation #
### Prérequis ###
```angular2html
$ Port 80 should be open ( apache2, nginx etc could use it )
$ mkdir -p ~/projects && cd ~/projects
$ git clone git@github.com:Sky15977/adminDockCompose.gi
```

### Step 1 - Env Vars ###
```angular2html
$ cp .env.dist ./.env
```
- modify all '/PATH/TO/DIR' by absolute or relative path

### Step 2 - Create Docker Network and Run ###
```angular2html
$ docker compose up --build -d
```

### Step final - Delete all Docker Network ###
```angular2html
$ docker rm -f $(docker ps -a -q)
```

### Access migration ###
```angular2html
$ docker exec -ti php bash
$ php bin/console doctrine:migrations:migrate
$ php bin/console doctrine:migrations:diff

$ php bin/console doctrine:migrations:migrate --force
```
