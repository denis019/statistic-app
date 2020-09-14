# Statistic app

## Installation

1. ```git clone git@github.com:denis019/statistic-app.git```
2. ```cd statistic-app```
3. ```cp .env.example .env```
4. update .env with AUTH_CLIENT_ID
5. ```cd docker```
6. ```./build.sh```
7. ```./run.sh```

## Used technologies
- php8.0
- docker

## Used libraries
- symfony/dependency-injection
- symfony/http-client
- symfony/dotenv
- symfony/config

## Features
* DDD
* Easy to add new statistic requirements
* Non blocking parallel requests with symfony/http-client

### TODO
* Add tests