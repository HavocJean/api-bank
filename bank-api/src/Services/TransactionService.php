<?php

namespace App\Services;

use PDO;
use Exception;
use App\Contracts\AccountRepositoryInterface;
use App\Exceptions\AccountNotFoundException;
use App\Exceptions\BalanceNotFoundException;
use App\Strategy\PaymentTaxStrategy;
use App\Strategy\CreditTaxStrategy;
use App\Strategy\DebitTaxStrategy;
use App\Strategy\PixTaxStrategy;

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
                throw new AccountNotFoundException();
            }

            $strategy = $this->resolveTaxStrategy($paymentMethod);

            $totalValue = $strategy->calculate($value);

            if($account['saldo'] < $totalValue) {
                throw new BalanceNotFoundException();
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

    public function resolveTaxStrategy(string $method) :PaymentTaxStrategy {
        return match ($method) {
            'C' => new CreditTaxStrategy(),
            'D' => new DebitTaxStrategy(),
            'P' => new CreditTaxStrategy(),            
            default => throw new Exception('Forma de pagamento invalida')
        };
    }
}