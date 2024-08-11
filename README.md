#  O'Secours 

**_O'secours est une application destinée aux associations de la protection animale, leur permettant de gérer leurs refuges, adoptions, actions etc_**

Ce projet, toujours en évolution, à été réalisé en fin de cycle Concepteur Développeur d'Applications.

                                        
## App dispo en démo
[Démo O'secours](https://osecours-front-eu-851bfe93cb8c.herokuapp.com/login)

Dans l'attente de la mise en place sur le nouveau serveur cette adresse est indisponible ~~https://www.osecours-asso.fr~~

N'hésitez pas à me contacter pour avoir les identifiants de test



## [Lien Jira](https://gaelleb.atlassian.net/jira/software/projects/OSV1/boards/1)

Destiné à la gestion du projet, pour l'équipe dev.


### Mise en place du projet

On root of project create a .env file with the following info: 
```
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```


**Setup env**
```
cp ./backend/.env.example ./backend/.env
cp ./frontend/.env.example .frontend/.env

cd backend
composer install
php artisan storage:link

cd frontend
npm install
```


**Backend cmd**

```
docker compose up --build
docker exec -it <container name> bash > php artisan migrate --seed

```



  

Now API backend can be reached on port http://localhost:8000 and front end on port http://localhost:5173
