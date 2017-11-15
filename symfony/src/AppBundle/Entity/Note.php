<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *@ORM\Entity
 *@ORM\Table(name="note")
 */
class Note
{
    /**
     * @ORM\Column(type="decimal")
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="Book", inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Id
     */
    private $book;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Id
     */
    private $user;

    /**
     * Get the value of Note
     *
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set the value of Note
     *
     * @param mixed note
     *
     * @return self
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get the value of Book
     *
     * @return mixed
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Set the value of Book
     *
     * @param mixed book
     *
     * @return self
     */
    public function setBook($book)
    {
        $this->book = $book;

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
}
