<?php

namespace App\Controllers;

use App\Repositories\AccountRepository;

class AccountController {

    public function register() :void {
        $data = json_decode(file_get_contents("php://input"), true);

        if(!isset($data['numero_conta']) || !isset($data['saldo'])) {
            http_response_code(400);
            echo json_encode(["error" => "Dados invalidos"]);
            return;
        }

        $accountNumber = filter_var($data['numero_conta'], FILTER_VALIDATE_INT);
        $balance = filter_var($data['saldo'], FILTER_VALIDATE_FLOAT);

        if ($accountNumber === false || $accountNumber <= 0) {
            http_response_code(400);
            echo json_encode(["error" => "Numero da conta deve ser um numero inteiro e positivo"]);
            return;
        }

        if ($balance === false || $balance < 0) {
            http_response_code(400);
            echo json_encode(["error" => "Saldo deve ser maior ou igual a zero"]);
            return;
        }

        $accountRepository = new AccountRepository();

        if($accountRepository->existsAccount($accountNumber)) {
            http_response_code(409);
            echo json_encode(["error" => "Conta ja existe"]);
            return;
        }

        $accountRepository->createAccount(
            $accountNumber,
            $balance
        );

        http_response_code(201);

        echo json_encode([
            "numero_conta" => (int)$accountNumber,
            "saldo" => (float)$balance
        ]);
    }

    public function show() :void {
        $accountNumber = $_GET['numero_conta'] ?? null;

        if(empty($accountNumber)) {
            http_response_code(404);
            return;
        }

        $accountNumber = filter_var($accountNumber, FILTER_VALIDATE_INT);
        
        if ($accountNumber === false || $accountNumber <= 0) {
            http_response_code(400);
            echo json_encode(["error" => "Numero da conta deve ser um número inteiro positivo"]);
            return;
        }

        $accountRepository = new AccountRepository();

        if(!$account = $accountRepository->findByAccountNumber($accountNumber)) {
            http_response_code(404);
            echo json_encode(["error" => "Conta não encontrada"]);
            return;
        }

        http_response_code(200);

        echo json_encode([
            "numero_conta" => (int)$account['numero_conta'],
            "saldo" => (float)$account['saldo']
        ]);
    }
}