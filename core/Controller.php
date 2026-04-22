<?php

declare(strict_types=1);

namespace Core;

abstract class Controller
{
    /**
     * @param string $view
     * @param array $params
     * @return void
     */
    protected function render(string $view, array $params = []): void
    {
        View::render($view, $params);
    }

    /**
     * @param string $message
     * @param int $httpCode
     * @return void
     */
    protected function error(string $message, int $httpCode = 500): void
    {
        http_response_code($httpCode);
        try {
            View::render('error', [
                'httpCode' => $httpCode,
                'message' => $message,
            ]);
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
        }
        exit;
    }
}