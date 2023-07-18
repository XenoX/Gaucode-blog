tu:
	vendor/bin/phpunit -vvv

tu-coverage:
	XDEBUG_MODE=coverage vendor/bin/phpunit -vvv --coverage-html coverage
