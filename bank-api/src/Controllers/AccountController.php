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

        $accountRepository = new AccountRepository();

        if($accountRepository->exists($data['numero_conta'])) {
            http_response_code(400);
            echo json_encode(["error" => "Conta ja existe"]);
            return;
        }

        $accountRepository->create(
            $data['numero_conta'],
            $data['saldo']
        );

        http_response_code(201);

        echo json_encode([
            "numero_conta" => (int)$data['numero_conta'],
            "saldo" => (float)$data['saldo']
        ]);
    }

    public function show() :void {
        $accountNumber = $_GET['numero_conta'] ?? null;

        if(empty($accountNumber)) {
            http_response_code(404);
            return;
        }

        $accountRepository = new AccountRepository();

        if(!$account = $accountRepository->findByAccountNumber($accountNumber)) {
            http_response_code(404);
            return;
        }

        http_response_code(200);

        echo json_encode($account);
    }
}