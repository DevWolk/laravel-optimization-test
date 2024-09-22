# - IGNORE ERROR; @ - SUPPRESS COMMAND VERBOSITY; PHONY used to ensure that command is always executed even if a file with the same name exists;
.SILENT: \
	install generate-config \
	laravel-check symfony-check laravel-profile symfony-profile \
	laravel-clear-opcache symfony-clear-opcache \
	build up stop down clean laravel-sh symfony-sh

.PHONY: build up stop down clean

export $(shell sed 's/=.*//' .env)
include variables.mk

install:
	make generate-config
	make build
	make up

laravel-check:
	docker compose exec laravel_app sh -c "php /var/www/html/laravel-test.php"

symfony-check:
	docker compose exec symfony_app sh -c "php /var/www/html/symfony-test.php"

laravel-profile:
	docker compose exec -e BLACKFIRE_CLIENT_ID=${BLACKFIRE_CLIENT_ID} \
		-e BLACKFIRE_CLIENT_TOKEN=${BLACKFIRE_CLIENT_TOKEN} \
		laravel_app blackfire run php ../laravel-test.php

symfony-profile:
	docker compose exec -e BLACKFIRE_CLIENT_ID=${BLACKFIRE_CLIENT_ID} \
		-e BLACKFIRE_CLIENT_TOKEN=${BLACKFIRE_CLIENT_TOKEN} \
		symfony_app blackfire run php ../symfony-test.php

laravel-clear-opcache:
	docker compose exec laravel_app php vendor/bin/cachetool opcache:reset --fcgi=127.0.0.1:9000

symfony-clear-opcache:
	docker compose exec symfony_app php vendor/bin/cachetool opcache:reset --fcgi=127.0.0.1:9000

generate-config:
	@docker compose $(COMPOSE_FILE) config > docker-compose.yml

build:
	@docker compose build --no-cache --pull

up:
	docker compose up -d
	docker compose exec laravel_app sh -c "\
		composer install --optimize-autoloader --no-interaction --prefer-dist --classmap-authoritative --no-dev && \
		php artisan migrate --force && \
		php artisan optimize:clear && \
		php artisan optimize"
	docker compose exec symfony_app sh -c "\
		composer install --optimize-autoloader --no-interaction --prefer-dist --classmap-authoritative --no-dev && \
		php bin/console cache:clear && \
		php bin/console cache:warmup"

stop:
	docker compose stop

down:
	docker compose down

clean:
	docker compose down -v --remove-orphans

laravel-sh:
	docker compose exec -it laravel_app sh
symfony-sh:
	docker compose exec -it symfony_app sh