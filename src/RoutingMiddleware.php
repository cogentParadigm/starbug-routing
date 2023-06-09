<?php
namespace Starbug\Routing;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Starbug\Routing\RouterInterface;

class RoutingMiddleware implements MiddlewareInterface {
  /**
   * The router which produces a route for the request.
   *
   * @var RouterInterface
   */
  protected $router;
  /**
   * The logger instance.
   *
   * @var LoggerInterface
   */
  protected $logger;

  /**
   * Dependencies needed to produce a route.
   *
   * @param RouterInterface $router Router translates paths to controllers.
   * @param LoggerInterface $logger To write log messages.
   */
  public function __construct(RouterInterface $router, LoggerInterface $logger) {
    $this->router = $router;
    $this->logger = $logger;
  }

  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
    $route = $this->router->route($request);
    $response = $handler->handle($request->withAttribute("route", $route));
    return $response;
  }
}
