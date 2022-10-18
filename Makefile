build:
	docker build -t fc-php .

run:
	docker run -d --name ff-core -v ${PWD}/:/code -w /code fc-php

deps:
	docker exec -it ff-core composer install

test:
	docker exec -it ff-core /code/vendor/bin/phpunit /code/src/FF/tests/ --colors=always -v
