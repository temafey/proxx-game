$(shell (if [ ! -e .env ]; then cp default.env .env; fi))
include .env
export

RUN_ARGS = $(filter-out $@,$(MAKECMDGOALS))

include .make/utils.mk
include .make/composer.mk
include .make/static-analysis.mk

.PHONY: install
install: erase build start wait setup ## clean current environment, recreate dependencies and spin up again

.PHONY: install-lite
install-lite: build start

.PHONY: start
start: ##up-services ## spin up environment
	docker-compose up -d

.PHONY: stop
stop: ## stop environment
	docker-compose stop

.PHONY: remove
remove: ## remove project docker containers
	docker-compose rm -v -f

.PHONY: erase
erase: stop remove docker-remove-volumes ## stop and delete containers, clean volumes

.PHONY: build
build: ## build environment and initialize composer and project dependencies
	docker network rm ${DOCKER_NETWORK_NAME}
	docker network create ${DOCKER_NETWORK_NAME}
	docker build .docker/php$(PHP_VER)-cli/ -t docker.local/$(CI_PROJECT_PATH)/php$(PHP_VER)-cli:master --build-arg CI_COMMIT_REF_SLUG=$(CI_COMMIT_REF_SLUG) --build-arg CI_SERVER_HOST=$(CI_SERVER_HOST) --build-arg CI_PROJECT_PATH=$(CI_PROJECT_PATH) --build-arg PHP_VER=$(PHP_VER)
	docker build .docker/php$(PHP_VER)-cli-composer/ -t docker.local/$(CI_PROJECT_PATH)/php$(PHP_VER)-cli-composer:master ${DOCKER_BUILD_ARGS} --build-arg CI_COMMIT_REF_SLUG=$(CI_COMMIT_REF_SLUG) --build-arg CI_SERVER_HOST=$(CI_SERVER_HOST) --build-arg CI_PROJECT_PATH=$(CI_PROJECT_PATH) --build-arg PHP_VER=$(PHP_VER)
	docker build .docker/php$(PHP_VER)-cli-dev/ -t docker.local/$(CI_PROJECT_PATH)/php$(PHP_VER)-cli-dev:master ${DOCKER_BUILD_ARGS} --build-arg CI_COMMIT_REF_SLUG=$(CI_COMMIT_REF_SLUG) --build-arg CI_SERVER_HOST=$(CI_SERVER_HOST) --build-arg CI_PROJECT_PATH=$(CI_PROJECT_PATH) --build-arg PHP_VER=$(PHP_VER)
	docker build .docker/php$(PHP_VER)-fpm-dev/ -t docker.local/$(CI_PROJECT_PATH)/php$(PHP_VER)-cli-dev:master ${DOCKER_BUILD_ARGS} --build-arg CI_COMMIT_REF_SLUG=$(CI_COMMIT_REF_SLUG) --build-arg CI_SERVER_HOST=$(CI_SERVER_HOST) --build-arg CI_PROJECT_PATH=$(CI_PROJECT_PATH) --build-arg PHP_VER=$(PHP_VER)
	docker-compose build --pull
	make composer-install

.PHONY: generate-ssl
generate-ssl:
	docker-compose run --rm $(PHP_CONTAINER_NAME) sh -lc 'mkdir -p ./var/jwt'
	docker-compose run --rm $(PHP_CONTAINER_NAME) sh -lc 'openssl genrsa -out var/jwt/private.pem -aes256 4096'
	docker-compose run --rm $(PHP_CONTAINER_NAME) sh -lc 'openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem'

.PHONY: setup
setup: setup-db ## setup database and run migrations

.PHONY: setup-db
setup-db: ## recreate database
	docker-compose run --rm $(PHP_CONTAINER_NAME) sh -lc './bin/console d:d:d --force --if-exists'
	docker-compose run --rm $(PHP_CONTAINER_NAME) sh -lc './bin/console d:d:c'
	docker-compose run --rm $(PHP_CONTAINER_NAME) sh -lc './bin/console d:m:m -n'

.PHONY: composer-preload
composer-preload: ## Generate preload config file
	docker-compose run --rm --no-deps $(PHP_CONTAINER_NAME) sh -lc 'composer preload'

.PHONY: clear-events
clear-events: ## setup enqueue
	docker-compose run --rm $(PHP_CONTAINER_NAME) sh -lc './bin/console cleaner:clear db'

.PHONY: schema-validate
schema-validate: ## validate database schema
	docker-compose run --rm $(PHP_CONTAINER_NAME) sh -lc './bin/console d:s:v'

.PHONY: migration-generate
migration-generate: ## generate new database migration
	docker-compose run --rm $(PHP_CONTAINER_NAME) sh -lc './bin/console d:m:g'

.PHONY: migration-migrate
migration-migrate: ## run database migration
	docker-compose run --rm $(PHP_CONTAINER_NAME) sh -lc './bin/console d:m:m'

.PHONY: micro-generate
micro-generate: ## run microservice generator
	docker-compose run --rm $(PHP_CONTAINER_NAME) sh -lc 'php ./generator.php'

.PHONY: game-start
game-start: ## start new game
	docker-compose run --rm $(PHP_CONTAINER_NAME) sh -lc './bin/console game:start'

.PHONY: php-shell
php-shell: ## PHP shell
	docker-compose run --rm $(PHP_CONTAINER_NAME) sh -l

.PHONY: php-test
php-test: ## PHP shell without deps
	docker-compose run --rm --no-deps $(PHP_CONTAINER_NAME) sh -l

.PHONY: clean
clean: ## Clear build vendor report folders
	rm -rf build/ vendor/ var/

.PHONY: test static-analysis coding-standards tests-unit tests-integration composer-validate
test: install static-analysis coding-standards tests-unit tests-integration composer-validate stop ## Run all test suites
