start:
	php artisan serve

migrate:
	php artisan migrate

deploy:
	git push heroku

lint:
	composer phpcs