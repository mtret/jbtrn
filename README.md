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

Run migrations:
```
make migrate
```


## Requesting data

App contains several endpoints. 
To get your expected response, always use an auth header: X-AUTH-TOKEN, value is an accessToken stored in User model.

Typical request to this api might look like this:

```

GET http://localhost/api/monitoring-results/7
Accept: application/json
Cache-Control: no-cache
X-AUTH-TOKEN: dcb20f8a-5657-4f1b-9f7f-ce65739b359e

```


### List of endpoints:

#### /api/monitoring-results/{id}

Returns last 10 results of monitored endpoints saved http status codes and payloads. Id parameter is monitored endpoint's id. 


#### /api/monitored-endpoint 

Creates new monitored endpoint. Example request:

```
POST http://localhost/api/monitored-endpoint
Accept: application/json
Cache-Control: no-cache
X-AUTH-TOKEN: dcb20f8a-5657-4f1b-9f7f-ce65739b359e

{ "dateCreated": "2019-01-01 00:00:01",  "name": "test",  "url": "http://alfabeta.cz",  "dateLastChecked": "2019-01-01 00:00:01", "monitoredInterval": 1 }

###

```

#### /api/monitored-endpoint/{id}

Depending on the http method used, updates/deletes/lists monitored endpoint.

Update:
```
PUT http://localhost/api/monitored-endpoint/10
Accept: application/json
Cache-Control: no-cache
X-AUTH-TOKEN: dcb20f8a-5657-4f1b-9f7f-ce65739b359e

{ "dateCreated": "2019-01-01 00:00:01",  "name": "test", "url": "http://alfabeta.cz", "dateLastChecked": "2019-01-01 00:00:01", "monitoredInterval": 1     }

###
```

Delete:

 ```
DELETE http://localhost/api/monitored-endpoint/10
Accept: application/json
Cache-Control: no-cache
X-AUTH-TOKEN: dcb20f8a-5657-4f1b-9f7f-ce65739b359e

###
```

Get:

```
GET http://localhost/api/monitored-endpoint/11
Accept: application/json
Cache-Control: no-cache
X-AUTH-TOKEN: dcb20f8a-5657-4f1b-9f7f-ce65739b359e

###
```

#### /api/monitored-endpoints

Lists all endpopints of given user (user is identified by the token in X-AUTH-TOKEN header.

```
GET http://localhost/api/monitored-endpoints
Accept: application/json
Cache-Control: no-cache
X-AUTH-TOKEN: dcb20f8a-5657-4f1b-9f7f-ce65739b359e

###
```
