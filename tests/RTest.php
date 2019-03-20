<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use const BSFP\R\Method\{ GET, POST, ALL };
use BSFP\R\{Route, ImRoute, RouteNotFoundException};

final class RTest extends TestCase
{

  public function testMatchingRoute(): void
  {
    $routes = new \BSFP\R(new \ArrayIterator([
      (new Route())->setMethod(GET)
                  ->setPath('/test')
                  ->setAction('test-single')
                  ->build(),
      (new Route())->setMethod(ALL)
                  ->setPath('/test/:id', ['id' => '\\d+'])
                  ->setAction('test-with-param')
                  ->build(),
      (new Route())->setMethod(POST)
                  ->setPath('/test/it')
                  ->setAction('test-it')
                  ->build(),
    ]));

    $routesReduced = $routes->reduce(POST);
    $route = $routesReduced->fetch('/test/it');
    $this->assertInstanceOf(ImRoute::class, $route);
    $this->assertEquals('test-it', $route->getAction());
    $this->assertFalse($route->hasMatches());

    $route = $routes->fetch('/test/12');
    $this->assertEquals('test-with-param', $route->getAction());
    $this->assertTrue($route->hasMatches());
    $this->assertEquals('12', $route->getMatch('id'));

    $route = $routes->fetch('/test');
    $this->assertEquals('test-single', $route->getAction());

    $this->expectException(RouteNotFoundException::class);
    $routesReduced->fetch('/test');
  }
}
