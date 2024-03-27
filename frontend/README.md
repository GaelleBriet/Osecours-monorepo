## Lancer le serveur de developpement

- `docker-compose up -d`
- `npm run dev`

## Configurer prettier pour qu'il soit éxécuté à chaque sauvegarde

### WebStorm

- Allez dans File > Settings (ou WebStorm > Preferences pour macOS)
- Naviguez jusqu'à Languages & Frameworks > JavaScript > Prettier
- Cochez la case Run on save for files
- Cliquez sur Apply puis OK pour enregistrer les modifications

### VSCode

- Allez dans File > Preferences > Settings (ou appuyez sur Ctrl + ,)
- Recherchez Editor: Format On Save et activez l'option
- Recherchez Editor: Default Formatter et sélectionnez esbenp.prettier-vscode

## Scripts

- `npm run dev` : Lance le serveur de développement
- `npm run build` : Compile le projet
- `npm run start` : Lance le serveur de production
- `npm run lint` : Lance le linter
- `npm run test` : Lance les tests
- `npm run format` : Formate le code

## Structure du projet

- `Assets/scss` : Fichiers de styles globaux
- `Components/` : Composants réutilisables
- `Controllers/` : Contrôleurs pour les pages
- `Interfaces/` : Interfaces TypeScript
- `Locales/` : Traductions
- `Router/` : Routes de l'application
- `Services/` : Services
- `Services/DataLayers` : Services d'appel API
- `Services/Helpers` : Services d'aide
- `Stores/` : Stores de l'application
- `Views/` : Pages de l'application

## Construction d'un fichier

- script : `script setup lang="ts"`
- template : `template`
- style : `style lang="scss" scoped`
- scoped : permet de limiter le style au composant actuel
- lang : permet de spécifier le langage du fichier
- setup : permet d'utiliser les options de composition API
- exemple :

```
<script setup lang="ts"></script>
<template></template>
<style lang="scss" scoped></style>
```
