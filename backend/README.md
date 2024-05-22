## Update Swagger documentation
```
sh > cd backend
sh > ./vendor/bin/openapi app -o public/swagger/swagger.yaml
```

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


[//]: # (    - name: Build Docker image)

[//]: # (      run: docker build -t registry.heroku.com/osecours-api/web ./backend)

[//]: # ()
[//]: # (    - name: Push and release Docker images)

[//]: # (      run: |)

[//]: # (        docker push registry.heroku.com/osecours-api/web)

[//]: # (        heroku container:release web --app osecours-api)
