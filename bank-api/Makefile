build:
	docker build -f docker/php/Dockerfile -t bank-api .

up:
	docker compose -f docker/php/docker-compose.yml up -d

down:
	docker compose -f docker/php/docker-compose.yml down

logs:
	docker compose -f docker/php/docker-compose.yml logs -f

migrate:
	docker exec bank_api_app php src/Database/Migrate.php

test:
	docker exec -it bank_api_app ./vendor/bin/phpunit
