<?php

namespace App\Contracts;

interface AccountRepositoryInterface
{
    public function existsAccount(int $accountNumber) :bool;

    public function createAccount(
        int $accountNumber,
        float $balance
    ) :void;

    public function findByAccountNumber(
        int $accountNumber
    ) :?array;

    public function findByAccountNumberForUpdate(
        int $accountNumber
    ) :?array;

    public function updateBalance(
        int $accountNumber,
        float $balance
    ) :void;

}