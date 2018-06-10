<?php
/**
 * Created by PhpStorm.
 * User: chokri
 * Date: 05/06/18
 * Time: 23:46
 */

namespace AppBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
###
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

###

/**
 * Class WebserviceUser
 * @package AppBundle\Security\User
 *
 */
class WebserviceUser implements UserInterface, EquatableInterface
{
    /**
     * @var
     * @Serializer\SerializedName("username")
     * @Serializer\Type(name="string")
     */
    private $username;
    /**
     * @var string
     * @Serializer\Type(name="string")
     */
    private $name;
    /**
     * @var string
     * @Serializer\Type(name="string")
     * @Serializer\SerializedName("lastName")
     */
    private $lastName;
    /**
     * @var string
     * @Serializer\Type(name="string")
     */
    private $email;
    private $password;
    private $salt;
    /**
     * @var integer
     * @Serializer\Type(name="integer")
     */
    private $id;
    /**
     * @var array
     * @Serializer\Type(name="array")
     */
    private $roles;
    /**
     * @var string $accessToken
     * @Expose()
     * @Serializer\SerializedName("accessToken")
     * @Serializer\Type(name="string")
     */
    private $accessToken;

    /**
     * Get categoryID
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLastName()
    {
        return $this->lastName;
    }
    public function setLastName($lastName)
    {
         $this->lastName = $lastName;
        return $this;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function __construct($username, $password, $salt, array $roles, $accessToken)
    {
        $this->username = $username;
        $this->password = $password;
        $this->salt = $salt;
        //$this->roles = $roles;
        $this->setRoles($roles);
        $this->accessToken = $accessToken;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
        //print_r($this->roles);
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
    }

    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof WebserviceUser) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->salt !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }
}