PROJECT_NAME = symfony-api
COMPOSER = docker-compose exec php composer
SYMFONY = docker-compose exec php symfony
PHP = docker-compose exec php php
CONSOLE = docker-compose exec php php bin/console
DOCKER_COMPOSE = docker-compose

all: build up install install-test

build:
	@echo "Building Docker containers..."
	$(DOCKER_COMPOSE) build

up:
	@echo "Starting Docker containers..."
	$(DOCKER_COMPOSE) up -d

down:
	@echo "Stopping Docker containers..."
	$(DOCKER_COMPOSE) down

install: install-dependencies setup-jwt generate-keys setup-database

install-dependencies:
	@echo "Installing dependencies..."
	$(COMPOSER) install

setup-jwt:
	@echo "Setting up JWT Authentication..."
	$(COMPOSER) require lexik/jwt-authentication-bundle

generate-keys:
	@echo "Generating JWT keys..."
	$(DOCKER_COMPOSE) exec php mkdir -p config/jwt
	$(DOCKER_COMPOSE) exec php openssl genrsa -out config/jwt/private.pem -aes256 4096
	$(DOCKER_COMPOSE) exec php openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
	$(DOCKER_COMPOSE) exec php chmod 600 config/jwt/private.pem config/jwt/public.pem
	$(CONSOLE) lexik:jwt:generate-keypair --overwrite --no-interaction
	@echo "JWT keys generated."

setup-database:
	@echo "Setting up the database..."
	$(CONSOLE) doctrine:database:create --if-not-exists
	$(CONSOLE) doctrine:schema:update --force
	$(CONSOLE) doctrine:fixtures:load --no-interaction

update-database:
	@echo "Updating the database..."
	$(CONSOLE) doctrine:schema:update --force

start:
	@echo "Starting the Symfony server..."
	$(SYMFONY) server:start

stop:
	@echo "Stopping the Symfony server..."
	$(SYMFONY) server:stop

clean:
	@echo "Cleaning up..."
	rm -rf var/cache/*
	rm -rf var/log/*
	rm -rf config/jwt/private.pem config/jwt/public.pem
	$(DOCKER_COMPOSE) down -v --remove-orphans

install-test:
	$(CONSOLE) --env=test doctrine:database:create
	$(CONSOLE) --env=test doctrine:schema:create
	$(CONSOLE) --env=test doctrine:fixtures:load --no-interaction

test:
	$(PHP) ./vendor/bin/phpunit

.PHONY: all build up down install install-dependencies setup-jwt generate-keys setup-database update-database start stop clean
