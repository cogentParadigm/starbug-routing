<?php
namespace Starbug\Routing\Resolvers;

use Starbug\Db\DatabaseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Starbug\Routing\Route;

class RowById {
  public function __construct(DatabaseInterface $db, ServerRequestInterface $request) {
    $this->db = $db;
    $this->request = $request;
  }
  public function __invoke(Route $route, $model, $id = false) {
    $bodyParams = $this->request->getParsedBody();
    $id = $id ?? $bodyParams["id"];
    $idMismatch = (!empty($bodyParams["id"]) && $bodyParams["id"] != $id);
    $record = $this->getRecord($model, $id);
    if ($idMismatch || empty($record)) {
      $route->notFound();
      return;
    }
    return $record;
  }
  protected function getRecord($model, $id) {
    return $this->db->get($model, $id);
  }
}
