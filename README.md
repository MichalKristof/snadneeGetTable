# GetTable

## Project setup

### Prerequisites

* [Docker Desktop](https://www.docker.com/products/docker-desktop)

### Initialization

1.  Copy `.env.example` to `.env` (copy command: `cp .env.example .env`)
2. `composer install --ignore-platform-reqs` - install composer dependencies

#### Note:
recommend to use wsl distro if you use windows

`alias sail='./vendor/bin/sail'` - create alias for use sail command


3. `sail up -d` - build and start environment in docker
4. `sail npm install` - install npm dependencies (or locally using `npm install`)
5. `sail php artisan key:generate --force` - regenerate application key
6. `sail artisan migrate:fresh --seed` - run migrations and seeders
7. `sail npm run build` - build assets (css, js, vue)
8.  Modify your [hosts file](https://support.rackspace.com/how-to/modify-your-hosts-file/)

    ```
    127.0.0.1 getTable
    ```

### Unit tests

`sail artisan test` - run unit tests

# Notes

### Basic Usage

1. `sail artisan` - access Artisan interface inside container
2. `sail bash` - access bash shell inside container 
3. `sail up -d` - start environment
4. `sail php artisan migrate:fresh --seed` - run migrations and seeders
5. `sail artisan test` - run unit tests
5. `sail down` - destroy environment

App running on [http://getTable](http://getTable)

### Tips

1. MySQL Console

    ```bash
    sail mysql
    ```

2. Change application expose ports

   To change default expose ports (80, 3306) add following environment variables to `.env` file:

        APP_PORT=8080
        FORWARD_DB_PORT=3307

   After changing `.env` file it's necessary to recreate containers to reload environment variables:

        sail up -d

3. Running single test

        sail artisan test --filter 'Tests\\Feature\\HomeTest'
