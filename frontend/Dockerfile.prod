# Étape de construction
FROM node:16-alpine as build-stage

WORKDIR /app

# Copier les fichiers de package.json et package-lock.json
COPY package*.json ./

# Installer les dépendances
RUN npm install

# Copier le reste du code source de l'application
COPY . .

# Construire l'application
RUN npm run build

# Étape de production
FROM nginx:stable-alpine as production-stage
COPY --from=build-stage /app/dist /usr/share/nginx/html

EXPOSE 80



CMD ["nginx", "-g", "daemon off;"]





