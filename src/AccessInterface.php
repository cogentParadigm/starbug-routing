<?php
namespace Starbug\Routing;

interface AccessInterface {
  public function hasAccess(Route $route);
}
