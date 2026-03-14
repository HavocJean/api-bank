<?php

namespace App\Validation;

use InvalidArgumentException;

class CreateTransactionRequest
{
    public static function validate(array $data) :array 
    {

        if (
            !isset($data['forma_pagamento']) ||
            !isset($data['numero_conta']) ||
            !isset($data['valor'])
        ) {
            throw new InvalidArgumentException("Dados inválidos.");
        }
    
        $paymentMethod = $data['forma_pagamento'];
        $accountNumber = filter_var($data['numero_conta'], FILTER_VALIDATE_INT);
        $value = filter_var($data['valor'], FILTER_VALIDATE_FLOAT);
    
        if (!in_array($paymentMethod, ['P', 'C', 'D'])) {
            throw new InvalidArgumentException("Forma de pagamento deve ser pix, credito ou debito.");
        }
    
        if ($accountNumber === false || $accountNumber <= 0) {
            throw new InvalidArgumentException("Numero da conta deve ser um número.");
        }
    
        if ($value === false || $value <= 0) {
            throw new InvalidArgumentException("Valor deve ser um numero positivo.");
        }
    
        return [
            'payment_method' => $paymentMethod,
            'number_account' => $accountNumber,
            'value' => $value
        ];
    }
}