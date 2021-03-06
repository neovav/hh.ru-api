# hh.ru-api

This is library for access to hh.ru Api

Tests:

1. To get $authCode go to the following link in your browser: https://hh.ru/oauth/authorize?response_type=code&client_id={client_id}&state={state}&redirect_uri={redirect_uri}
2. Copy file: tests/.env-sample to tests/.env and change values
3. Build docker container:

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

    c. For testing personal: 
    
    ```bash
    docker run --env-file tests/.env hh.ru-api php -f tests/personal.php
    ```

    d. For testing active vacancies: 
    
    ```bash
    docker run --env-file tests/.env hh.ru-api php -f tests/vacancies_active.php
    ```

    e. For testing negotiation: 
    
    ```bash
    docker run --env-file tests/.env hh.ru-api php -f tests/vacancies_active.php
    ```
   
Using in your projects:

1. Install package using composer:

```bash
composer require neovav/hh.ru-api:1.0.4
```