<?php

namespace App\Repositories;

use App\Database\Connection;
use PDO;

class AccountRepository {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Connection::get();
    }

    public function exists(int $accountNumber) :bool {
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

    public function create(int $accountNumber, float $balance) :void {
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
}