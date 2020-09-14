#!/usr/bin/env bash

## Set the output colors
green=`tput setaf 2`

docker-compose up --build -d

docker exec social_network_statistic-php_fpm composer install

echo "${green}App is ready!${reset}"
echo "${green}Run: run.sh${reset}"
