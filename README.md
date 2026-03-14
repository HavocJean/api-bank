# Api Bank Pure PHP

API REST Gestão bancária

## Como executar

```bash
cd bank-api
```

### Build e subir

```bash
make build    # Build das imagens
make up       # Subir os containers
```

A API estará disponível em `http://localhost:8000`

### Migração

```bash
make migrate
```

### Outros comandos

```bash
make logs     # Ver logs dos containers
make down     # Derrubar os containers
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

## Estrutura

```
bank-api/
├── docker/php/          
├── public/
│   └── index.php       
├── src/
│   ├── Controllers/    
│   ├── Contracts/      
│   ├── Database/       
│   ├── Exceptions/    
│   ├── Helpers/        
│   ├── Repositories/   
│   ├── Router/         
│   ├── Services/       
│   └── Validation/     
├── composer.json
└── vendor/
```