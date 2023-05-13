build:
	docker build -t fc-php .

run:
	docker run -d --name ff-core -v ${PWD}/:/code -w /code fc-php

start:
	docker start ff-core

stop:
	docker stop ff-core

deps:
	docker exec -it ff-core composer install

php:
	docker exec -it ff-core bash

test:
	docker exec -it ff-core /code/vendor/bin/phpunit /code/src/FF/tests/ --colors=always -v

test-coverage:
	docker exec -it ff-core ./vendor/bin/phpunit --coverage-text ./src

cs:
	docker exec -it ff-core ./vendor/bin/phpcs ./src

psalm:
	docker exec -it ff-core ./vendor/bin/psalm
md:
	docker exec -it ff-core ./vendor/bin/phpmd