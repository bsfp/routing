<?php
namespace BSFP\R;

use PathToRegexp;

class Route
{
  private $method = Method\ALL;

  private $path;

  private $parameters;

  private $action;

  private $is_secured = false;

  private $matches;

  private $matchKeys;

  private $regexp;

  private $is_regexp;

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

  public function setIsSecured(): Route
  {
    $this->is_secured = true;

    return $this;
  }

  public function build(): ImRoute
  {
    $this->is_regexp = !(strpos($this->path, ':') === false) && count($this->parameters) !== 0;

    if ($this->is_regexp) {
      $keys = [];
      $values = [];

      $this->matchKeys = array_keys($this->parameters);

      foreach ($this->parameters as $key => $value) {
        $keys[] = ":{$key}";
        $values[] = "({$value})";
      }

      $this->regexp = '/' . str_replace($keys, $values, addcslashes($this->path, '/')) . '/';
    }

    return new ImRoute($this);
  }

  public function match(string $path): bool
  {
    if ($this->is_regexp) {
      return (bool)preg_match($this->regexp, $path, $this->matches);
    } else {
      return ($path === $this->path);
    }
  }

  public function getMatch(string $key)
  {
    $index = array_search($key, $this->matchKeys);
    return $this->matches[$index + 1];
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

  public function getMatches(): ?array
  {
    return $this->matches;
  }

  public function getAction()
  {
    return $this->action;
  }

  public function getIsSecured(): bool
  {
    return $this->is_secured;
  }
}
