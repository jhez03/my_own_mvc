<?php

namespace Core;

class Router
{
  protected array $routes = [];


  public function add(string $method, string $uri, string $controller): void
  {

    $this->routes[] = [
      'method' => strtoupper($method),
      'uri' => $uri,
      'controller' => $controller
    ];
  }

  public static function notFound(): string
  {
    http_response_code(404);
    echo View::render('errors/404');

    exit;
  }

  public function dispatch(string $uri, string $method): string
  {

    $route = $this->findRoute($uri, $method);

    if (!$route) {
      return static::notFound();
    }

    [$controller, $action] = explode('@', $route['controller']);
    return $this->callAction($controller, $action, $route['params']);
  }

  protected function findRoute(string $uri, string $method): ?array
  {
    foreach ($this->routes as $route) {
      if ($route['method'] === $method) {
        $params = $this->matchRoute($route['uri'], $uri);
        if ($params !== null) {
          return [
            'controller' => $route['controller'],
            'params' => $params
          ];
        }
      }
    }
    return null;
  }

  protected function matchRoute(string $routeUri, string $requestUri): ?array
  {
    $routeSegments = explode('/', trim($routeUri, '/'));
    $requestSegments = explode('/', trim($requestUri, '/'));

    if (count($routeSegments) !== count($requestSegments)) {
      return null;
    }

    $params = [];

    foreach ($routeSegments as $index => $segment) {
      if (str_starts_with($segment, '{') && str_ends_with($segment, '}')) {
        $paramName = trim($segment, '{}');
        $params[$paramName] = $requestSegments[$index];
      } elseif ($segment !== $requestSegments[$index]) {
        return null;
      }
    }

    return $params;
  }

  protected function callAction(string $controller, string $action, array $params): string
  {
    $controllerClass = "App\\Controllers\\$controller";
    return (new $controllerClass)->$action($params);
  }
}
