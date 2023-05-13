# Routing Library

A routing library for the Starbug PHP framework.

# Setup

First implement RouteProviderInterface to define routes.

```php
namespace MyApp;

use Starbug\Routing\RouteProviderInterface;
use Starbug\Routing\Controller;
use Starbug\Routing\Controller\ViewController;

class RouteProvider implements RouteProviderInterface {
  /**
   * @param Route $routes This is the root path "/"
   */
  public function configure(Route $routes) {
    // Configure the root path
    $routes->setController(ViewController::class);
    $routes->setOption("view", "home.html");

    // This Route is added from the root so the full path is "/" + "home" = "/home"
    $home = $routes->addRoute("home", ViewController::class, [
      "view" => "home.html"
    ]);
    $routes->addRoute("missing", [Controller::class, "missing"]);
    $routes->addRoute("forbidden", [Controller::class, "forbidden"]);

    // Adding from the above "/home" Route, the full path will  be "/home/test"
    $home->addRoute("/test", ViewController::class, [
      "view" => "test.html"
    ]);
  }
}
```

Next create a Route Configuration with one or more provider instances.

```php
namespace MyApp;

use Starbug\Routing\Configuration;

$config = new Configuration();
$provider = new RouteProvider();

$config->addProvider($provider);
```

Next use the Configuration object to create a RouteStorageInterface implementation.
We will use the included FastRouteStorage.

```php
namespace MyApp;

use Starbug\Routing\FastRouteStorage;

$dispatcher = FastRouteStorage::createDispatcher($config);
$storage = new FastRouteStorage($dispatcher, $access);

```

Now we can instantiate a Router.

```php
namespace MyApp;

use Starbug\Routing\Router;

// Must be instance of Invoker\InvokerInterface
$invoker;

$router = new Router($invoker);
$router->addStorage($storage);
```

# Usage

You can use the router directly or use the provided PSR-15 middlewares (RoutingMiddleware and ControllerMiddleware).

```php
// Pass in a PSR-7 ServerRequestInterface instance and get back the route.
$route = $this->router->route($request);
```

