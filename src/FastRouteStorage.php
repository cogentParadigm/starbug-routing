<?php
namespace Starbug\Routing;

use FastRoute\DataGenerator\GroupCountBased;
use FastRoute\Dispatcher;
use FastRoute\Dispatcher\GroupCountBased as DispatcherGroupCountBased;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use Psr\Http\Message\ServerRequestInterface;

class FastRouteStorage implements RouteStorageInterface {
  /**
   * FastRoute Dispatcher
   *
   * @var Dispatcher
   */
  protected $dispatcher;
  protected $routes = [];
  public function __construct(Dispatcher $dispatcher, AccessInterface $access) {
    $this->dispatcher = $dispatcher;
    $this->access = $access;
  }
  public function getRoute(ServerRequestInterface $request) {
    $path = $request->getUri()->getPath();
    $routeInfo = $this->dispatcher->dispatch("GET", $path);
    if ($routeInfo[0] == Dispatcher::FOUND) {
      $route = $routeInfo[1];
      $vars = $routeInfo[2];
      if (!$this->access->hasAccess($route)) {
        $route->forbidden();
      }
      $route->setOptions($vars);
      return $route;
    }
  }
  public static function createDispatcher(Configuration $config, $options = []): Dispatcher {
    $options += [
      'routeParser' => Std::class,
      'dataGenerator' => GroupCountBased::class,
      'dispatcher' => DispatcherGroupCountBased::class,
      'routeCollector' => RouteCollector::class
    ];

    $routeCollector = new $options["routeCollector"](
      new $options["routeParser"](),
      new $options["dataGenerator"]()
    );

    $routes = $config->getRoutes();
    foreach ($routes as $route) {
      $routeCollector->addRoute("GET", $route->getPath(), $route);
    }

    return new $options['dispatcher']($routeCollector->getData());
  }
}
