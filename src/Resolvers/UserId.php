<?php
namespace Starbug\Routing\Resolvers;

use Starbug\Auth\SessionHandlerInterface;

class UserId {
  public function __invoke(SessionHandlerInterface $session) {
    return $session->getUserId();
  }
}
