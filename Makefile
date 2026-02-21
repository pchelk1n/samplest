CLI_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
$(eval $(sort $(subst :,\:,$(CLI_ARGS))):;@:)

PRIMARY_GOAL := $(firstword $(MAKECMDGOALS))
ifeq ($(PRIMARY_GOAL),)
    PRIMARY_GOAL := help
endif

# Current user ID and group ID except MacOS where it conflicts with Docker abilities
ifeq ($(shell uname), Darwin)
    export USER_ID=1000
else
    export USER_ID=$(shell id -u)
endif

DOCKER_COMPOSE_COMMAND := docker compose -f docker/compose.yml

build:
	$(DOCKER_COMPOSE_COMMAND) build

up:
	$(DOCKER_COMPOSE_COMMAND) up --detach --wait --wait-timeout 60 --force-recreate --remove-orphans

down:
	$(DOCKER_COMPOSE_COMMAND) down --remove-orphans

shell:
	$(DOCKER_COMPOSE_COMMAND) run --rm php-cli $(CLI_ARGS)
