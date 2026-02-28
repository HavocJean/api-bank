# Api Bank Pure PHP

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

## Endpoints

### Criar conta

**POST /conta**

```json
{
 "numero_conta": 1234,
 "saldo": 150.37
}
```

**Exemplo:**
```bash
curl -X POST http://localhost:8000/conta \
-H "Content-Type: application/json" \
-d '{
"numero_conta":1234,
"saldo":150.37
}'
```

### Buscar conta

**GET /conta?numero_conta=1234**

**Exemplo:**
```bash
curl http://localhost:8000/conta?numero_conta=1234
```

### Realizar transação

**POST /transacao**

**Formas de pagamento:**
- **P** → Pix (sem taxa)
- **D** → Débito (3% de taxa)
- **C** → Crédito (5% de taxa)

**Exemplo:**
```bash
curl -X POST http://localhost:8000/transacao \
-H "Content-Type: application/json" \
-d '{
"forma_pagamento":"D",
"numero_conta":1234,
"valor":10
}'
```
