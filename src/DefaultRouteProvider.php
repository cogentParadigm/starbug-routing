<?php
namespace Starbug\Routing;

/**
 * Registers the default routes configured under routing.defaults.
 *
 * Each entry maps a path to a controller, so an application can override a
 * path or disable the route by setting the value to false.
 */
class DefaultRouteProvider implements RouteProviderInterface {
  public function __construct(
    protected array $defaults
  ) {
  }

  public function configure(Route $routes) {
    foreach ($this->defaults as $path => $controller) {
      if (is_string($path) && $path !== "" && $controller) {
        $routes->addRoute($path, $controller);
      }
    }
  }
}
