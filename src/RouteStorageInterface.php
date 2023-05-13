<?php
namespace Starbug\Routing;

use Psr\Http\Message\ServerRequestInterface;

interface RouteStorageInterface {
  public function getRoute(ServerRequestInterface $request);
}
