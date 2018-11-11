<?php
namespace BSFP\R;

class Route
{
  private $method;

  private $path;

  private $parameters;

  private $action;

  public function __construct() 
  {}

  public function setMethod(string $method): Route
  {
    $this->method = $method;

    return $this;
  }

  public function setPath(string $path, ?array $parameters = null): Route
  {
    $this->path = $path;
    $this->parameters = $parameters;

    return $this;
  }

  public function setAction($action): Route
  {
    $this->action = $action;

    return $this;
  }

  public function build(): ImRoute
  {
    return new ImRoute($this);
  }

  public function getMethod(): string
  {
    return $this->method;
  }

  public function getPath(): string
  {
    return $this->path;
  }

  public function getParameters(): ?array
  {
    return $this->parameters;
  }

  public function getAction()
  {
    return $this->action;
  }
}