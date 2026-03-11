<?php

namespace App\Validation;

use InvalidArgumentException;

class CreateAccountRequest
{
    public static function validate(array $data) :array
    {
        if (!isset($data['numero_conta']) || !isset($data['saldo'])) {
            throw new InvalidArgumentException("Dados inválidos");
        }

        $accountNumber = filter_var($data['numero_conta'], FILTER_VALIDATE_INT);
        $balance = filter_var($data['saldo'], FILTER_VALIDATE_FLOAT);

        if ($accountNumber === false || $accountNumber <= 0) {
            throw new InvalidArgumentException("Numero da conta deve ser um numero inteiro e positivo");
        }

        if ($balance === false || $balance < 0) {
            throw new InvalidArgumentException("Saldo deve ser maior ou igual a zero");
        }

        return [
            'account_number' => $accountNumber,
            'balance' => $balance
        ];
    }
}