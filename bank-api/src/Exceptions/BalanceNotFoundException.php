<?php

namespace App\Exceptions;

use Exception;

class BalanceNotFoundException extends Exception
{
    protected $message = "Saldo insuficiente";
}