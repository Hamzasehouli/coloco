<?php

declare(strict_types=1);

namespace coloco\helpers;

class ErrorHandler{
    public static function run(int $statusCode, string $message)
    {
    $status = str_starts_with("$statusCode", '4')? 'fail':'error';

    http_response_code($statusCode);
    echo(json_encode(['status' => "$status", 'message' => $message]));
    exit;
    }
};

?>