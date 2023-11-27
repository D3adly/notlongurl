This is a demo of a url shortener implementation. 
The purpose of this application is to demonstrate url generation and redirect functionality.
It is not intended to be used in production.

Missing features
* Authentication
* Authorization
* Validation
* Tests
* Logging
* Actual URL generation in real world implementation is suggested as a separate service which issues pre-generated short urls
* Length of short url is intentionally chosen as 5 characters for the demo purposes, in production it should be 6-7 characters, depending on use case.


## Set up
1. Start Docker containers with `docker-compose -f .docker/docker-compose.yml up -d --build` command.
2. Install dependencies `docker exec -it symfony_dockerized-php-1 sh -c "composer intall"`
3. Run migrations `docker exec -it symfony_dockerized-php-1 sh -c "sf doc:mig:mig"`
4. For ease of setup, localized docker config and .env config files are included in the repo.

### API
1. DB is seeded with user entry.
2. Make API requests:

With predefined url:
```http request
POST http://notlongurl.local/api/url
Content-Type: application/json
Accept: application/json

{
"real_url": "https://www.google.com",
"short_url": "something"
"user_id": 1,
"active": true
}
```

With random url:
```http request
POST http://notlongurl.local/api/url
Content-Type: application/json
Accept: application/json

{
"real_url": "https://www.bing.com",
"user_id": 1,
"active": true
}
```
short url will be returned as part of url object in response

### Redirect

1. Go to http://notlongurl.local/something and you will be redirected to https://www.google.com
2. Go to `http://notlongurl.local/{short url received from api}` and you will be redirected to https://www.bing.com