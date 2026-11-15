<?php
namespace Starbug\Routing;

use function DI\autowire;
use function DI\get;
use FastRoute\Dispatcher;

return [
  // Path => controller. Set a value to false to leave the path undefined,
  // or override the path in the application's own etc/di.php.
  "routing.defaults" => [
    "missing" => [Controller::class, "missing"],
    "forbidden" => [Controller::class, "forbidden"]
  ],
  "route.providers" => [
    get(DefaultRouteProvider::class)
  ],
  DefaultRouteProvider::class => autowire()
    ->constructorParameter("defaults", get("routing.defaults")),
  Configuration::class => autowire()
    ->method("addProviders", get("route.providers")),
  Dispatcher::class => function ($container) {
    return FastRouteStorage::createDispatcher($container->get(Configuration::class));
  },
  RouterInterface::class => autowire(Router::class)
    ->method("addStorage", get(FastRouteStorage::class)),
  'Starbug\Routing\*Interface' => autowire('Starbug\Routing\*')
];
