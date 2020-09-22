#!/usr/bin/env bash
## Set the script's folder as PWD, no matter from which path it got run.
cd "$(dirname "$0")"

## Set the output colors
green=`tput setaf 2`

cd ../docker
docker-compose up --build -d

docker exec social_network_statistic-php_fpm composer install

echo "${green}App is ready!${reset}"
echo "${green}Run: ./bin/run.sh${reset}"
