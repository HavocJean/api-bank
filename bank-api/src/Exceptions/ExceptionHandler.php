<?php

namespace App\Exceptions;

class ExceptionHandler 
{
    public static function handle(Throwable $e) {
        switch (true) {
            case $e instanceof AccountNotFoundException:
                Response::error($e->getMessage(), 404);
                break;
            
            case $e instanceof BalanceNotFoundException:
                Response:error($e->getMessage(), 422);
                break;

            default:
                Response::error("Internal error", 500);
        }
    }
}
