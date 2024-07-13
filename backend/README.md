

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

## Se connecter au container postgres

```
docker exec -it osecours-monorepo_postgres_1 bash psql -U sail -d laravel 
```
ou
```docker exec -it osecours-monorepo_postgres_1 psql -U sail -d osecours_test```

créer une db de test
```CREATE DATABASE osecours_test; GRANT ALL PRIVILEGES ON DATABASE osecours_test TO sail;```

lister les bases de données
```\l```

se connecter à une base de données
```\c nom de la base de données```

lister les tables  
```\dt```

s'assurer que .env.testing est bien configuré
```docker exec -it laravel_backend cat .env.testing```

executer les migrations pour l'env de test
```docker exec -it -e APP_ENV=testing laravel_backend php artisan migrate --seed```

Nettoyer le cache de configuration
```docker exec -it laravel_backend bash php artisan config:clear```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
