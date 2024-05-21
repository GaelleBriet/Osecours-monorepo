## Lancer le serveur de developpement
- `docker-compose up -d` à la racine du projet

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

## Scripts utiles à lancer régulièrement :
- `npm run lint` : Lance le linter
- `npm run format` : Formate le code

## Structure du projet
- `Assets/scss` : Fichiers de styles globaux
- `tailwind.config.js` : Configuration de TailwindCSS
- `Components/` : Composants réutilisables
- `Controllers/` : Contrôleurs pour les pages
- `Interfaces/` : Interfaces TypeScript
- `Locales/` : Traductions
- `Router/` : Routes de l'application
- `Services/` : Services
- `Services/DataLayers` : Services d'appel API
- `Services/Helpers` : Services d'aide
- `Services/Translations` : Configuration de i18n
- `Stores/` : Stores de l'application
- `Views/` : Pages de l'application

## Construction d'un fichier
- script : `script setup lang="ts"` 
  - setup : permet d'utiliser les options de composition API
  - lang : permet de spécifier le langage du fichier 
- template : `template`
- style : `style lang="scss" scoped` 
  - scoped : permet de limiter le style au composant actuel
  - lang : permet de spécifier le langage du fichier, à définir si l'un utilise Sass
- exemple :

```
<script setup lang="ts"></script>
<template></template>
<style lang="scss" scoped></style>
```

## Bonnes pratiques (à remplir au fur et à mesure)
### CSS
- Éviter de surcharger le css sur les différentes vues. Si le css est global et s'applique à tous les éléments du site, préféré l'inscrire dans Assets/css/*
### Locales
- Utiliser le fichier Locales/fr.json pour les mots/textes/traductions (et si le coeur vous en dit le fichier en.json)
- Tout inscrire minuscule, sauf les noms propres
  - Pour afficher le texte d'une traduction, utiliser la fonction t('chemin.de.la.cle') de i18n
  - Ne pas oublier les imports liés : `import i18n from '@/Services/Translations/index.ts';
    import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts'; `
  - Déclarer la const t pour les traductions : `const t = i18n.global.t;`
  - Utiliser et importer la methode getCapitalizedText pour les majuscules: `import { getCapitalizedText } from '@/Services/Helpers/TextFormat.ts';`
  - Example : `<h1>{{ getCapitalizedText(t('pages.home.welcomeMessage')) }}</h1>`
  