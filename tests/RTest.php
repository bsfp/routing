<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use const BSFP\R\Method\{ GET, POST, ALL };

final class RTest extends TestCase
{

  public function testMatchingRoute(): void
  {
    $routes = new \BSFP\R([
      (new Route())->setMethod(GET)
                   ->setPath('/test')
                   ->build(),
      (new Route())->setMethod(GET)
          ->setPath('/test')
          ->build(),
    ]);
  }
}
