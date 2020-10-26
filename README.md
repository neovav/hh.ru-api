# hh.ru-api

This is library for access to hh.ru Api

Tests:

1. Copy file: tests/.env-sample to tests/.env and change values
2. Build docker container:

```bash
docker build -t hh.ru-api .
```

3. Launch test file:

    a. For testing oAuth: 
    
    ```bash
    docker run --env-file tests/.env hh.ru-api php -f tests/checkoAuth.php
    ```

    b. For testing vacancies: 
    
    ```bash
    docker run --env-file tests/.env hh.ru-api php -f tests/vacancies.php
    ```
   
Using in your projects:

1. Install package using composer:

```bash
composer require neovav/hh.ru-api:1.0.1
```