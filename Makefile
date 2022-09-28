start:
	php artisan serve

setup:
	composer install
	cp -n .env.example .env
	php artisan key:gen --ansi
	npm ci
	npm run build

migrate:
	php artisan migrate

deploy:
	git push heroku main

lint:
	composer exec --verbose phpcs -- --standard=PSR12 app

test:
	composer exec --verbose phpunit tests

stan:
	vendor/bin/phpstan analyse -c phpstan.neon

test-coverage:
	composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml
