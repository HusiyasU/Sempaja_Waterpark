<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, array $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    public function put(string $path, array $handler): void
    {
        $this->addRoute('PUT', $path, $handler);
    }

    public function delete(string $path, array $handler): void
    {
        $this->addRoute('DELETE', $path, $handler);
    }

    private function addRoute(string $method, string $path, array $handler): void
    {
        $this->routes[] = [
            'method'  => $method,
            'path'    => $path,
            'handler' => $handler,
        ];
    }

    public function dispatch(string $method, string $uri): void
    {
        // Hapus query string
        $uri = strtok($uri, '?');
        if (empty($uri)) $uri = '/';

        if (isset($_GET['list_routes'])) {
            $list = array_map(fn($r) => $r['method'] . ' ' . $r['path'], $this->routes);
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode(['routes' => $list, 'uri' => $uri, 'method' => $method]);
            exit;
        }

        foreach ($this->routes as $route) {
            $pattern = $this->pathToRegex($route['path']);

            if ($route['method'] === $method && preg_match($pattern, $uri, $matches)) {
                array_shift($matches);

                [$controllerClass, $action] = $route['handler'];

                if (!class_exists($controllerClass)) {
                    $this->respond(500, ['success' => false, 'message' => "Controller {$controllerClass} not found"]);
                    return;
                }

                $controller = new $controllerClass();

                if (!method_exists($controller, $action)) {
                    $this->respond(500, ['success' => false, 'message' => "Method {$action} not found"]);
                    return;
                }

                call_user_func_array([$controller, $action], $matches);
                return;
            }
        }

        $this->respond(404, [
            'success' => false,
            'message' => 'Route not found',
            'uri'     => $uri,
            'method'  => $method,
        ]);
    }

    private function pathToRegex(string $path): string
    {
        $pattern = preg_replace('/\{([a-zA-Z_]+)\}/', '([^/]+)', $path);
        return '#^' . $pattern . '$#';
    }

    private function respond(int $status, array $data): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}