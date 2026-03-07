<?php

namespace App\Controllers;

use App\Helpers\Response;
use App\Services\TransactionService;
use Exception;

class TransactionController {
    private TransactionService $service;

    public function __construct(TransactionService $transactionService) {
        $this->service = $transactionService;
    }

    public function transaction(): void {
        $data = json_decode(file_get_contents('php://input'), true);

        if (
            !isset($data['forma_pagamento']) ||
            !isset($data['numero_conta']) ||
            !isset($data['valor'])
        ) {
            Response::error("Dados inválidos.", 400);
            return;
        }

        $paymentMethod = $data['forma_pagamento'];
        $accountNumber = filter_var($data['numero_conta'], FILTER_VALIDATE_INT);
        $value = filter_var($data['valor'], FILTER_VALIDATE_FLOAT);

        if (!in_array($paymentMethod, ['P', 'C', 'D'])) {
            Response::error("Forma de pagamento deve ser pix, credito ou debito.", 400);
            return;
        }

        if ($accountNumber === false || $accountNumber <= 0) {
            Response::error("Numero da conta deve ser um número.", 400);
            return;
        }

        if ($value === false || $value <= 0) {
            Response::error("Valor deve ser um numero positivo.", 400);
            return;
        }

        $result = $this->service->process(
            $paymentMethod,
            $accountNumber,
            $value
        );

        Response::success($result, 201);
    }
}