<?php
namespace Starbug\Routing\Resolvers;

use Starbug\Db\DatabaseInterface;

class RowByInsertId {
  public function __invoke(DatabaseInterface $db, $model) {
    if ($id = $db->getInsertId($model)) {
      return $db->get($model, $id);
    }
    return null;
  }
}
