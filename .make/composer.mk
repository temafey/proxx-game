ifeq ($(OS),Windows_NT)
    CWD := $(lastword $(dir $(realpath $(MAKEFILE_LIST)/../)))
else
    CWD := $(abspath $(patsubst %/,%,$(dir $(abspath $(lastword $(MAKEFILE_LIST))))/../))/
endif

.PHONY: composer-install
composer-install: ## Install project dependencies
	docker-compose --project-directory $(CWD) -f $(CWD)docker-compose.yml run --rm --no-deps $(PHP_CONTAINER_NAME) sh -lc 'composer install --ignore-platform-reqs'

.PHONY: composer-install-no-dev
composer-install-no-dev: ## Install project dependencies without dev
	docker-compose --project-directory $(CWD) -f $(CWD)docker-compose.yml run --rm --no-deps $(PHP_CONTAINER_NAME) sh -lc 'composer install --no-dev --ignore-platform-reqs'

.PHONY: composer-update
composer-update: ## Update project dependencies
	docker-compose --project-directory $(CWD) -f $(CWD)docker-compose.yml run --rm --no-deps $(PHP_CONTAINER_NAME) sh -lc 'composer update --ignore-platform-reqs'

.PHONY: composer-outdated
composer-outdated: ## Show outdated project dependencies
	docker-compose --project-directory $(CWD) -f $(CWD)docker-compose.yml run --rm --no-deps $(PHP_CONTAINER_NAME) sh -lc 'composer outdated --ignore-platform-reqs'

.PHONY: composer-validate
composer-validate: ## Validate composer config
		docker-compose --project-directory $(CWD) -f $(CWD)docker-compose.yml run --rm --no-deps $(PHP_CONTAINER_NAME) sh -lc 'composer validate --no-check-publish  --ignore-platform-reqs'

.PHONY: composer
composer: ## Execute composer command
	docker-compose --project-directory $(CWD)/ -f $(CWD)docker-compose.yml run --rm --no-deps $(PHP_CONTAINER_NAME) sh -lc "composer $(RUN_ARGS) --ignore-platform-reqs"

.PHONY: composer-test
composer-test: ## Run unit and code style tests.
	docker-compose --project-directory $(CWD)/ -f $(CWD)docker-compose.yml run --rm --no-deps $(PHP_CONTAINER_NAME) sh -lc "composer test"

.PHONY: composer-fix-style
composer-fix-style: ## Automated attempt to fix code style.
	docker-compose --project-directory $(CWD)/ -f $(CWD)docker-compose.yml run --rm --no-deps $(PHP_CONTAINER_NAME) sh -lc "composer fix-style"
