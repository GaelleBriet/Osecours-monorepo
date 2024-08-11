## Mettre en place sa base de données de tests

- copier le fichier .env.testing.example en .env.testing
- se connecter au conteneur (sail : ton user , laravel : db)
- créer la bdd de test
- donner les droits à sail
- jouer les migrations et seeders
```
docker exec -it osecours-monorepo_postgres_1 bash
psql -U sail -d laravel
CREATE DATABASE osecours_test;
GRANT ALL PRIVILEGES ON DATABASE osecours_test TO sail;
```
```
docker exec -it -e APP_ENV=testing laravel_backend php artisan migrate:fresh --seed --env=testing --database=testing
```

⚠️⚠️ Attention, modification des données dans les seeders, vérifier les identifiants de connection en bdd ⚠️⚠️


## Update Swagger documentation
```
sh > cd backend
sh > php artisan l5-swagger:generate 
sh > ~~./vendor/bin/openapi app -o public/swagger/swagger.yaml~~
```

## Commandes diverses base de données de développement
- se connecter au conteneur
```
docker exec -it laravel_backend bash
```
- jouer les migrations et seeders
```
php artisan migrate:fresh --seed
```


## Commandes diverses base de données de test
- config clear + migration + seed + test
```
docker exec -it -e APP_ENV=testing laravel_backend php artisan config:clear
docker exec -it -e APP_ENV=testing laravel_backend php artisan migrate:fresh --seed --env=testing --database=testing
docker exec -it -e APP_ENV=testing laravel_backend php artisan test --env=testing --database=testing
```
- autres commandes utiles
- lister les bases de données
```
- \l
```
- se connecter à une base de données
```
- \c nom de la base de données
```
- lister les tables  
```
- \dt
```
- s'assurer que .env.testing est bien configuré
```
- docker exec -it laravel_backend cat .env.testing
```
- executer les migrations pour l'env de test
```
- docker exec -it -e APP_ENV=testing laravel_backend php artisan migrate --seed
```


## Commandes diverses pour les tests unitaires
- lancer 1 test unitaire en particulier 
```
composer test-run -- tests/Unit/Models/Species/SpeciesTest.php
```
- lancer tous les tests unitaires
```
composer test-run
```
- clear config
```
composer test-clear-config
```
- migration + seed
```
composer test-migrate
```
- jouer les trois actions à la fois
```
composer test-all
```






## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
