#!/usr/bin/env bash
# ____________________________________________________________________________________________
# How to use this script?
#
# Execute at root:
# ./php <command to execute at container>
#
# Examples:
# ./php php -v
# ./php composer install
# ./php composer update
# ____________________________________________________________________________________________


if [ ! "$(docker ps | grep wireless-logic-php)" ]; then
  make start
fi

docker exec -it wireless-logic-php $@
