<?php

namespace Gearbox\SecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gearbox\SecurityBundle\Model\UserInterface;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 */
class User extends BaseUser implements UserInterface
{
}