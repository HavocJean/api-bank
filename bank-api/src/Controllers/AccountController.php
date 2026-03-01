<?php

namespace App\Controllers;

use App\Helpers\Response;
use App\Contracts\AccountRepositoryInterface;

class AccountController {

    private AccountRepositoryInterface $accountRepository;

    public function __construct(
        AccountRepositoryInterface $accountRepository
    ) {
        $this->accountRepository = $accountRepository;
    }

    public function register() :void {
        $data = json_decode(file_get_contents("php://input"), true);

        if(!isset($data['numero_conta']) || !isset($data['saldo'])) {
            Response::error("Dados invalidos", 400);
            return;
        }

        $accountNumber = filter_var($data['numero_conta'], FILTER_VALIDATE_INT);
        $balance = filter_var($data['saldo'], FILTER_VALIDATE_FLOAT);

        if ($accountNumber === false || $accountNumber <= 0) {
            Response::error("Numero da conta deve ser um numero inteiro e positivo", 400);
            return;
        }

        if ($balance === false || $balance < 0) {
            Response::error("Saldo deve ser maior ou igual a zero", 400);
            return;
        }

        if($this->accountRepository->existsAccount($accountNumber)) {
            Response::error("Conta ja existe", 409);
            return;
        }

        $this->accountRepository->createAccount(
            $accountNumber,
            $balance
        );

        Response::success([
            "numero_conta" => (int)$accountNumber,
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