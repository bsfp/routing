<?php
namespace BSFP\R;

class ImRoute
{
  private $route;

  private $result = [];

  public function __construct(Route $route)
  {
    $this->route = $route;
  }

  public function match(string $path): bool
  {
    return $this->match($path);
  }

  public function getData(): array
  {
    return $this->result;
  }

  public function isSecured(): bool
  {
    return $this->route->getIsSecured();
  }

  public function getAction()
  {
    return $this->route->getAction();
  }

  public function getMethod(): string
  {
    return $this->route->getMethod();
  }

  public function getMatches(): ?array
  {
    return $this->route->getMatches();
  }
}
