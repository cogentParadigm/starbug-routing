<?php
namespace Starbug\Routing\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Starbug\Routing\Controller;

class ViewController extends Controller {
  public function __invoke($view, ServerRequestInterface $request): ResponseInterface {
    $arguments = $request->getAttribute("route")->getOptions();
    return $this->render($view, $arguments);
  }
}
