<?php

namespace App\Controllers;

use App\Helpers\Response;
use App\Contracts\AccountRepositoryInterface;
use App\Validation\CreateAccountRequest;

class AccountController {

    private AccountRepositoryInterface $accountRepository;

    public function __construct(
        AccountRepositoryInterface $accountRepository
    ) {
        $this->accountRepository = $accountRepository;
    }

    public function register() :void {
        $data = json_decode(file_get_contents("php://input"), true);

        $validated = CreateAccountRequest::validate($data);

        if($this->accountRepository->existsAccount($validated['account_number'])) {
            Response::error("Conta ja existe", 409);
            return;
        }

        $this->accountRepository->createAccount(
            $validated['account_number'],
            $validated['balance']
        );

        Response::success([
            "numero_conta" => (int)$validated['account_number'],
            "saldo" => (float)$balance
        ], 201);
    }

    public function show() :void {
        $accountNumber = $_GET['numero_conta'] ?? null;

        if(empty($accountNumber)) {
            Response::error("Numero da conta é obrigatório", 404);
            return;
        }

        $accountNumber = filter_var($accountNumber, FILTER_VALIDATE_INT);
        
        if ($accountNumber === false || $accountNumber <= 0) {
            Response::error("Numero da conta deve ser um número inteiro positivo", 400);
            return;
        }

        if(!$account = $this->accountRepository->findByAccountNumber($accountNumber)) {
            Response::error("Conta nao encontrada", 404);
            return;
        }

        Response::success([
            "numero_conta" => (int)$account['numero_conta'],
            "saldo" => (float)$account['saldo']
        ], 200);
    }
}