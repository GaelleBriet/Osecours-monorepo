

## Update Swagger documentation
```
sh > cd backend
sh > ./vendor/bin/openapi app -o public/swagger/swagger.yaml
```

## Base de données de test
```
docker exec -it -e APP_ENV=testing laravel_backend php artisan config:clear
docker exec -it -e APP_ENV=testing laravel_backend php artisan migrate:fresh --seed --env=testing --database=testing
docker exec -it -e APP_ENV=testing laravel_backend php artisan test --env=testing --database=testing
```

## Base de données de développement
```
docker exec -it laravel_backend bash
php artisan migrate:fresh --seed
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
