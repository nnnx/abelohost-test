<?php

declare(strict_types=1);

namespace Core;

use ReflectionMethod;

class Router
{
    /**
     * @var array<int, array{method:string, pattern:string, action:string}>
     */
    private array $routes = [];

    /**
     * Регистрация GET маршрута
     */
    public function get(string $pattern, string $action): void
    {
        $this->routes[] = [
            'method' => 'GET',
            'pattern' => $pattern,
            'action' => $action,
        ];
    }

    /**
     * Обработка запроса
     */
    public function dispatch(string $uri, string $method = 'GET'): void
    {
        // Убираем query string (?page=...)
        $path = trim((string)parse_url($uri, PHP_URL_PATH), '/');

        foreach ($this->routes as $route) {

            if ($route['method'] !== $method) {
                continue;
            }

            $compiled = $this->compile($route['pattern']);

            if (!preg_match($compiled['regex'], $path, $matches)) {
                continue;
            }

            array_shift($matches);

            $params = $this->mapParams($compiled['keys'], $matches);

            [$controller, $action] = explode('@', $route['action']);

            $class = "Controllers\\$controller";

            if (!class_exists($class)) {
                http_response_code(500);
                echo "Controller not found";
                return;
            }

            $controllerObj = new $class();

            $this->invoke($controllerObj, $action, $params);
            return;
        }

        View::render('error', [
            'httpCode' => 400,
            'message' => 'Not Found',
        ]);
    }

    /**
     * Компиляция шаблона маршрута в regex
     *
     * /category/{id:\d+}
     * → #^category/(\d+)$#
     */
    private function compile(string $pattern): array
    {
        $keys = [];

        $regex = preg_replace_callback(
            '#\{(\w+)(?::([^}]+))?\}#',
            function ($matches) use (&$keys) {
                $keys[] = $matches[1];

                $pattern = $matches[2] ?? '[^/]+';

                return '(' . $pattern . ')';
            },
            trim($pattern, '/')
        );

        return [
            'regex' => "#^{$regex}$#",
            'keys' => $keys,
        ];
    }

    /**
     * Преобразует параметры в ассоциативный массив
     *
     * ['id','page'] + ['10','2']
     * → ['id'=>10,'page'=>2]
     */
    private function mapParams(array $keys, array $values): array
    {
        $params = [];

        foreach ($keys as $i => $key) {
            $params[$key] = $values[$i] ?? null;
        }

        return $params;
    }

    /**
     * Вызывает метод контроллера с автоподстановкой параметров
     */
    private function invoke(object $controller, string $method, array $params): void
    {
        $reflection = new ReflectionMethod($controller, $method);

        $args = [];

        foreach ($reflection->getParameters() as $param) {
            $name = $param->getName();
            $args[] = $params[$name] ?? null;
        }

        $reflection->invokeArgs($controller, $args);
    }
}