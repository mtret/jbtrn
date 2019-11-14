# How to run

First clone the repo to a folder of your choosing.

### Prerequisites
* [docker](https://www.docker.com/)
* [docker-compose](https://docs.docker.com/compose/)
* Make

### Container
 - [nginx](https://hub.docker.com/_/nginx/) 1.16.+
 - [php-fpm](https://hub.docker.com/_/php/) 7.3.+
- [mysql](https://hub.docker.com/_/mysql/) 5.7.+

### Installing the app

Switch to the project folder and use make commands in the following order. 


Build and run containers:
```
 make build-up
```

Composer install:
```
 make composer-install 
```

Fix privileges (if needed):
```
 make chmod 
```

Prepare db schema:
```
make schema-init
```

Run migrations:
```
make migrate
```

### Automated tests

CodeCeption tests can be run with 

```
make tests
```
