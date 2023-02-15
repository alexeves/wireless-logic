# .PHONY will prevent any clashes between target names and files in this directory with the same name. If there is a file and PHONY is not used, it will execute that file.
.PHONY: *

build:
	docker-compose up -d
	docker exec -t wireless-logic-php composer install

run:
	docker exec -it wireless-logic-php apps/symfony/bin/console wireless-logic:list-products

run-tests:
	docker exec -it wireless-logic-php vendor/bin/phpunit
	docker exec -it wireless-logic-php vendor/bin/behat

run-code-analysis:
	docker exec -it wireless-logic-php vendor/bin/php-cs-fixer fix --no-interaction --diff -v --dry-run
	docker exec -it wireless-logic-php vendor/bin/phpstan analyse -l 9 src/ tests/
