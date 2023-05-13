<?php
namespace Starbug\Routing;

use Starbug\Routing\Traits\RouteProperties;
use Starbug\Routing\Traits\Routes;
use Starbug\Routing\Traits\Operations;
use Starbug\Routing\Traits\Resolvers;
use Starbug\Routing\Traits\Status;

class Route {

  use RouteProperties;
  use Routes;
  use Operations;
  use Resolvers;
  use Status;

  public function __construct($path, $controller = null, $options = [], $parent = null) {
    $this->path = $path;
    $this->controller = $controller;
    $this->options = $options;
    $this->parent = $parent;
  }
}
