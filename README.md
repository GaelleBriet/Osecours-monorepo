**Setup env**
```
cp ./backend/.env.example ./backend/.env

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
