<?php
/**
 * Created by PhpStorm.
 * User: chokri
 * Date: 08/06/18
 * Time: 22:15
 */

namespace AppBundle\Entity;


class Role
{
    /**
     * @var integer
     * @Serializer\Type(name="integer")
     */
    private $id;
    /**
     * @var string
     * @Serializer\Type(name="role")
     */
    private $role;
    public function getId()
    {
        return $this->id;
    }
    public function setRole($role)
    {
        return $this->role = $role;
    }
    public function getRole()
    {
        return $this->role;
    }
}