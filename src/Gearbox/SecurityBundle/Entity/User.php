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
    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get FirstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get LastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }


}