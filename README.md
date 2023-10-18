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

### Install ###
```angular2html
$
```

### For use 
```angular2html
$
```
