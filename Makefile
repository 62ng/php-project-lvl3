start:
	php artisan serve

setup:
	composer install

migrate:
	php artisan migrate

deploy:
	git push heroku

lint:
	composer exec --verbose phpcs -- --standard=PSR12 app

test:
	composer exec --verbose phpunit tests

test-coverage:
	composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml
