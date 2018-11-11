<?php
namespace BSFP;

class Routing
{
  private $routes;

  public function __construct(Iterable $routes)
  {
    $this->routes = $routes;
  }

  public function fetch($path): ?R\ImRoute
  {
    foreach ($this->routes as $route) {
      if ($route->match($path)) {
        return $route;
      }
    }
    return null;
  }

  public function fetchAll($path): array
  {
    return array_filter($this->routes, function ($route) use ($path) {
      return $route->match($path);
    });
  }
}
