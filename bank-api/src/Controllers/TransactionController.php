<?php

namespace App\Controllers;

use App\Helpers\Response;
use App\Services\TransactionService;
use Exception;
use App\Validation\CreateTransactionRequest;

class TransactionController {
    private TransactionService $service;

    public function __construct(TransactionService $transactionService) {
        $this->service = $transactionService;
    }

    public function transaction(): void {
        $data = json_decode(file_get_contents('php://input'), true);

       $validated = CreateTransactionRequest::validate($data);

        $result = $this->service->process(
            $paymentMethod,
            $accountNumber,
            $value
        );

        Response::success($result, 201);
    }
}