compose_command = docker-compose run -u $(id -u ${USER}):$(id -g ${USER}) --rm php81

SUB_ITEMS=50
RECURSION=50
WEB_RUNS=1000
WEB_CONCURRENCY=1

build:
	docker-compose build

shell: build
	$(compose_command) bash

destroy:
	docker-compose down -v

composer: build
	$(compose_command) composer install

test: build
	$(compose_command) vendor/bin/phpunit

phpstan: build
	$(compose_command) vendor/bin/phpstan

.PHONY: setupbench
setupbench:
	SUB_ITEMS=$(SUB_ITEMS) RECURSION=$(RECURSION) php setup-serialized.php

shellbench: setupbench
	SUB_ITEMS=$(SUB_ITEMS) RECURSION=$(RECURSION) php setup-serialized.php
	SUB_ITEMS=$(SUB_ITEMS) RECURSION=$(RECURSION) ./vendor/bin/phpbench run --report=overview

webbench: setupbench
	ab -n $(WEB_RUNS) -c $(WEB_CONCURRENCY) -d -q http://dumpbench.lndo.site/unserialize.php
	ab -n $(WEB_RUNS) -c $(WEB_CONCURRENCY) -d -q  http://dumpbench.lndo.site/require.php
