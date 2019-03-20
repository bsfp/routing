<?php
namespace BSFP;

use BSFP\R\Route;

class Routing
{
  private $routes;

  public function __construct(\Traversable $routes)
  {
    $this->routes = $routes;
  }

  /**
   * @param string $path
   * @param bool $noException
   * @return R\ImRoute|null
   * @throws R\RouteNotFoundException
   */
  public function fetch(string $path, bool $noException = false): ?R\ImRoute
  {
    foreach ($this->routes as $route) {
      /* @var R\ImRoute $route */
      if ($route->match($path)) {
        return $route;
      }
    }

    if ($noException) {
      return null;
    }

    throw new R\RouteNotFoundException();
  }

  /**
   * @param string $method
   * @return Routing
   */
  public function reduce(string $method): Routing
  {
    $routes = array_filter(iterator_to_array($this->routes, false), function ($route) use ($method) {
      /* @var R\ImRoute $route */
      return (
          $route->getMethod() === $method
       || $route->getMethod() === R\Method\ALL
      );
    });

    return new self(new \ArrayIterator($routes));
  }

  /**
   * @param $path
   * @return array
   */
  public function fetchAll(string $path): array
  {
    return array_filter(iterator_to_array($this->routes, false), function ($route) use ($path) {
      /* @var R\ImRoute $route */
      return $route->match($path);
    });
  }
}
