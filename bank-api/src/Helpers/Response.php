<?php

namespace App\Helpers;

class Response {
    public static function success(array $data, int $status = 200) :void {
        http_response_code($status);
        echo json_encode($data);
    }

    public static function error(string $message, int $status) :void {
        http_response_code($status);
        echo json_encode([
            "error" => $message
        ]);
    }
}