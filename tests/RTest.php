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

  public function testGetMatches(): void
  {
    $routes = new \BSFP\R(new \ArrayIterator([
      (new Route())->setAction('digit')->setPath('/:id', ['id' => '\\d+'])->build(),
      (new Route())->setAction('string')->setPath('/:key', ['key' => '\\w+'])->build(),
      (new Route())->setAction('string-digit')->setPath('/:key/:id', ['key' => '\\w+', 'id' => '\\d+'])->build(),
    ]));

    $route1 = $routes->fetch('/test');
    $this->assertTrue($route1->hasMatches());
    $this->assertEquals('string', $route1->getAction());
    $this->assertEquals('test', $route1->getMatch('key'));

    $route2 = $routes->fetch('/12');
    $this->assertTrue($route2->hasMatches());
    $this->assertEquals('digit', $route2->getAction());
    $this->assertEquals(12, $route2->getMatch('id'));

    $route3 = $routes->fetch('/test/12');
    $this->assertTrue($route3->hasMatches());
    $this->assertEquals('string-digit', $route3->getAction());
    $this->assertEquals('test', $route3->getMatch('key'));
    $this->assertEquals(12, $route3->getMatch('id'));
    $this->assertEquals(['key' => 'test', 'id' => 12], $route3->getAllMatches());
  }
}
