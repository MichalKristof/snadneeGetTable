# GetTable

## Project setup

### Prerequisites

* [Docker Desktop](https://www.docker.com/products/docker-desktop)

### Initialization

1. `composer install`
2. `sail up -d`
3. Modify your [hosts file](https://support.rackspace.com/how-to/modify-your-hosts-file/)

    ```
    127.0.0.1 getTable
    ```
4. Copy `.env.example` to `.env`

## Notes

### Basic Usage

1. `alias sail='./vednor/bin/sail'` - create alias for use sail command
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
