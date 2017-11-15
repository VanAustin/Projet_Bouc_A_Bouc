<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *@ORM\Entity
 *@ORM\Table(name="friend")
 */
class Friend
{
    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $accepted = false;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="myfriends")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Id
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="friendswithme")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Id
     */
    private $hasFriend;

    /**
     * Get the value of Accepted
     *
     * @return mixed
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * Set the value of Accepted
     *
     * @param mixed accepted
     *
     * @return self
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get the value of User
     *
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of User
     *
     * @param mixed user
     *
     * @return self
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of Has Friend
     *
     * @return mixed
     */
    public function getHasFriend()
    {
        return $this->hasFriend;
    }

    /**
     * Set the value of Has Friend
     *
     * @param mixed hasFriend
     *
     * @return self
     */
    public function setHasFriend($hasFriend)
    {
        $this->hasFriend = $hasFriend;

        return $this;
    }
}
