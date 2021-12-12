#!/usr/bin/env bash

cp .env.example .env

docker run --rm --interactive --tty --volume $PWD:/app composer install

./vendor/bin/sail up -d

./vendor/bin/sail artisan key:generate && ./vendor/bin/sail artisan storage:link && ./vendor/bin/sail artisan migrate --seed
