<?php

namespace App\Services;

use PDO;
use Exception;
use App\Contracts\AccountRepositoryInterface;

class TransactionService {
    private PDO $pdo;
    private AccountRepositoryInterface $accountRepository;

    public function __construct(
        PDO $pdo,
        AccountRepositoryInterface $accountRepository
    ) {
        $this->pdo = $pdo;
        $this->accountRepository = $accountRepository;
    }

    public function process(
        string $paymentMethod,
        int $accountNumber,
        float $value
    ) :array {

        $this->pdo->beginTransaction();

        try {
            if (!$account = $this->accountRepository->findByAccountNumberForUpdate($accountNumber)) {
                throw new Exception("Conta nao encontrada", 404);
            }

            $tax = $this->getTax($paymentMethod);

            $totalValue = $value + ($value * $tax);

            if($account['saldo'] < $totalValue) {
                throw new Exception("Saldo insuficiente", 404);
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