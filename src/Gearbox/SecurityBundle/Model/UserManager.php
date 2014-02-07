<?php


namespace Gearbox\SecurityBundle\Model;

use Gearbox\ApiBundle\Model\AbstractApiManager;
use Gearbox\SecurityBundle\Entity\User;

class UserManager extends AbstractApiManager
{
    public function create(array $parameters)
    {
        $user = $this->createEntity();

        return $this->processForm($user, $parameters, self::METHOD_POST);
    }

    public function update(User $user, array $parameters)
    {
        return $this->processForm($user, $parameters);
    }

    public function patch(User $user, array $parameters)
    {
        return $this->processForm($user, $parameters, self::METHOD_PATCH);
    }

    public function get($userName)
    {
        return $this->getRepository()->findOneBy(array('username' => $userName));
    }

    public function delete(User $user)
    {
        $this->deleteEntity($user);
    }
} 