<?php

namespace App\Exceptions;

use Exception;

class AccountNotFoundException extends Exception
{
    protected $message = "Conta nao encontrada";
}