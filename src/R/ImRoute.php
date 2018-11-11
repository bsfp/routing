<?php
namespace BSFP\R;

class ImRoute
{
  private $route;
  private $regex;

  private $result = [];

  public function __construct(Route $route)
  {
    $this->route = $route;
  }

  public function match(string $route): bool
  {
    return ($route === $this->getPath());
  }

  public function getData(): array
  {
    return $this->result;
  }

  public function getMethod(): string
  {
    return $this->route->getMethod();
  }

  public function getPath(): string
  {
    return $this->route->getPath();
  }

  public function getParameters(): ?array
  {
    return $this->route->getParameters();
  }

  public function getAction()
  {
    return $this->route->getAction();
  }
}
