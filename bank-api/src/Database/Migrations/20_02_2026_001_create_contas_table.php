<?php

return "
    CREATE TABLE IF NOT EXISTS contas (
        id SERIAL PRIMARY KEY,
        numero_conta INTEGER UNIQUE NOT NULL,
        saldo NUMERIC(12,2) NOT NULL CHECK(SALDO >=0),
        created_at TIMESTAMP DEFAULT NOW(),
        updated_at TIMESTAMP DEFAULT NOW()
    );
";