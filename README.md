**Setup env**
```
cp .env.example .env
```


**Backend cmd**

```
composer install 

alias sail="./vendor/bin/sail"

cd backend
composer install

sail up -d

docker exec -it <container name> bash puis php artisan migrate:fresh --seed

```

  
**Frontend cmd**

back to the root of the project 

    docker-compose up -d

  

Now API backend can be reached on port http://localhost:5555 and front end on port http://localhost:8080
