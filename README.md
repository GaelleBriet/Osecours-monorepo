**Lien Jira**
https://gaelleb.atlassian.net/jira/software/projects/OSV1/boards/1

**App dispo à cette adresse**
https://www.osecours-asso.fr

**Setup env**
```
cp ./backend/.env.example ./backend/.env
cd backend
composer install
php artisan storage:link

cd frontend
npm install
cp .env.example .env
```

On root of project create a .env file with the following info: 
```
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```


**Backend cmd**

```
docker compose up --build

docker exec -it <container name> bash > php artisan migrate --seed

```



  

Now API backend can be reached on port http://localhost:8000 and front end on port http://localhost:5173
