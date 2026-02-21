<?php

namespace App\Controllers;

use App\Services\TransactionService;
use Exception;

class TransactionController {
    private TransactionService $service;

    public function __construct() {
        $this->service = new TransactionService();
    }

    public function transaction() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['forma_pagamento']) || !isset($data['numero_conta']) || !isset($data['valor'])) {
            http_response_code(400);
            echo json_encode(["error" => "Dados inválidos"]);
            return;
        }

        if (!in_array($data['forma_pagamento'], ['P', 'C', 'D'])) {
            http_response_code(400);
            echo json_encode(["error" => "Forma de pagamento deve ser pix, credito ou debito."]);
            return;
        }

        $accountNumber = filter_var($data['numero_conta'], FILTER_VALIDATE_INT);
        if ($accountNumber === false || $accountNumber <= 0) {
            http_response_code(400);
            echo json_encode(["error" => "Numero da conta deve ser um número"]);
            return;
        }

        $value = filter_var($data['valor'], FILTER_VALIDATE_FLOAT);
        if ($value === false || $value <= 0) {
            http_response_code(400);
            echo json_encode(["error" => "Valor deve ser um numero positivo"]);
            return;
        }

        try {
            $result = $this->service->process(
                $data['forma_pagamento'],
                $accountNumber,
                $value
            );

            http_response_code(201);
            echo json_encode($result);
        } catch (Exception $e) {
            http_response_code(404);
            echo json_encode([
                'error' => $e->getMessage()
            ]);
        }
    }
}