SHELL:=/bin/bash

UID := $(shell id -u)
GID := $(shell id -g)

init: docker-down \
	docker-pull docker-build docker-up \
	composer-install \
	migrate

install: docker-down-clear \
	docker-pull docker-build docker-up \
	composer-install frontend-init \
	migrate

up: docker-up
down: docker-down
restart: down up

migrate-create:
	docker-compose exec -u $(UID):$(GID) api php yii migrate/create $(filename)

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build --pull

migrate:
	docker-compose exec -u $(UID):$(GID) api php yii migrate

migrate-down:
	docker-compose exec -u $(UID):$(GID) api php yii migrate/down

composer-install:
	docker-compose exec -u $(UID):$(GID) api composer install -n

composer-require:
	docker-compose exec -u $(UID):$(GID) api composer require $(filename)

frontend-init: # инициализация yii framework
	docker-compose exec -u $(UID):$(GID) api php init

