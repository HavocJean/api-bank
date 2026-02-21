<?php

namespace App\Services;

use App\Database\Connection;
use App\Repositories\AccountRepository;
use Exception;
use PDO;

class TransactionService {
    private PDO $pdo;
    private AccountRepository $accountRepository;

    public function __construct() {
        $this->pdo = Connection::get();
        $this->accountRepository = new AccountRepository($this->pdo);
    }

    public function process(
        string $paymentMethod,
        int $accountNumber,
        float $value
    ) :array {

        $this->pdo->beginTransaction();

        try {
            if (!$account = $this->accountRepository->findAccountNumberForUpdate($accountNumber)) {
                throw new Exception("Conta nao encontrada", 404);
            }

            $tax = $this->getTax($paymentMethod);

            $totalValue = $value + ($value * $tax);

            if($account['saldo'] < $totalValue) {
                throw new Exception("Saldo insuficiente", 422);
            }

            $newBalance = $account['saldo'] - $totalValue;

            $this->accountRepository->updateBalance(
                $account['id'],
                $newBalance
            );

            $this->pdo->commit();

            return [
                "numero_conta" => $accountNumber,
                "saldo" => round($newBalance, 2)
            ];
        } catch (Exception $e) {
            $this->pdo->rollback();
            throw $e;
        }
    }

    public function getTax(string $method) :float {
        return match ($method) {
            'D' => 0.03,
            'C' => 0.05,
            'P' => 0.00,            
            default => throw new Exception('Nao existe essa forma de pagamento')
        };
    }

}