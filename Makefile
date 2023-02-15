# Define a default target when only "make" is run on the command line without passing a target
.DEFAULT_GOAL := help

# .PHONY will prevent any clashes between target names and files in this directory with the same name. If there is a file and PHONY is not used, it will execute that file.
.PHONY: *

help:
	@printf "\033[33mUsage:\033[0m\n  make [target] [arg=\"val\"...]\n\n\033[33mTargets:\033[0m\n"
	@grep -E '^[-a-zA-Z0-9_\.\/]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[32m%-15s\033[0m %s\n", $$1, $$2}'

start:
	docker-compose up -d
	docker exec -t wireless-logic-php composer install

run:
	./php apps/symfony/bin/console wireless-logic:list-products

run-tests:
	./php vendor/bin/phpunit
	./php vendor/bin/behat

run-code-analysis:
	./php vendor/bin/php-cs-fixer fix --no-interaction --diff -v --dry-run
	./php vendor/bin/phpstan analyse -l 9 src/ tests/
