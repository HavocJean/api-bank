# Challenge Objective

API REST Gestão bancária

## Como executar

### Subir o projeto com Docker

```bash
cd bank-api/docker/php
docker-compose up --build
```

A API estará disponível em `http://localhost:8000`

### Executar migração

```bash
docker exec -it bank_api_app php src/Database/Migrate.php
```

### Comandos úteis

**Recarregar autoload:**
```bash
docker exec -it bank_api_app composer dump-autoload
```