<?php

namespace App\Repositories;

use App\Database\Connection;
use PDO;

class AccountRepository {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Connection::get();
    }

    public function existsAccount(int $accountNumber) :bool {
        $sql = "SELECT
                    1
                FROM
                    contas
                WHERE
                    numero_conta = :numero_conta";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "numero_conta" => $accountNumber
        ]);

        return (bool) $stmt->fetch();
    }

    public function createAccount(int $accountNumber, float $balance) :void {
        $sql = "INSERT INTO contas
                    (numero_conta, saldo)
                VALUES
                    (:numero_conta, :saldo)
                ";
        
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "numero_conta" => $accountNumber,
            "saldo" => $balance
        ]);
    }

    public function findByAccountNumber(int $accountNumber) :?array {
        $sql = "SELECT
                    numero_conta, saldo
                FROM
                    contas
                WHERE
                    numero_conta = :numero_conta";
        
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "numero_conta" => $accountNumber
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    public function findAccountNumberForUpdate(int $accountNumber) :?array {
        $sql = "SELECT
                    id, saldo
                FROM
                    contas
                WHERE
                    numero_conta = :numero_conta
                FOR UPDATE";
        
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "numero_conta" => $accountNumber
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    public function updateBalance(int $id, float $balance) :void {
        $sql = "UPDATE
                    contas
                SET
                    saldo = :saldo
                WHERE
                    id = :id";
        
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'saldo' => $balance,
            'id' => $id
        ]);
    }
}