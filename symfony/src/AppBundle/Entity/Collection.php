<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\MaxDepth;

/**
 *@ORM\Entity
 *@ORM\Table(name="collection")
 *@ORM\Entity(repositoryClass="AppBundle\Repository\CollectionRepository")
 */
class Collection
{
    /**
     *@ORM\Column(type="integer")
     *@ORM\Id
     *@ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $loanable = false;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $borrowed = false;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $borrowAsk = false;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $borrower;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $borrowDate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $borrowComment;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $private = false;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="collections")
     * @ORM\JoinColumn(onDelete="SET NULL")
     * @MaxDepth(2)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="Book", inversedBy="collections")
     * @ORM\JoinColumn(nullable=false)
     * @MaxDepth(4)
     */
    private $book;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="collections")
     * @ORM\JoinColumn(nullable=false)
     * @MaxDepth(1)
     */
    private $user;



    /**
     * Get the value of Id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of Loanable
     *
     * @return mixed
     */
    public function getLoanable()
    {
        return $this->loanable;
    }

    /**
     * Set the value of Loanable
     *
     * @param mixed loanable
     *
     * @return self
     */
    public function setLoanable($loanable)
    {
        $this->loanable = $loanable;

        return $this;
    }

    /**
     * Get the value of Borrowed
     *
     * @return mixed
     */
    public function getBorrowed()
    {
        return $this->borrowed;
    }

    /**
     * Set the value of Borrowed
     *
     * @param mixed borrowed
     *
     * @return self
     */
    public function setBorrowed($borrowed)
    {
        $this->borrowed = $borrowed;

        return $this;
    }

    /**
     * Get the value of Borrow Ask
     *
     * @return mixed
     */
    public function getBorrowAsk()
    {
        return $this->borrowAsk;
    }

    /**
     * Set the value of Borrow Ask
     *
     * @param mixed borrowAsk
     *
     * @return self
     */
    public function setBorrowAsk($borrowAsk)
    {
        $this->borrowAsk = $borrowAsk;

        return $this;
    }

    /**
     * Get the value of Borrower
     *
     * @return mixed
     */
    public function getBorrower()
    {
        return $this->borrower;
    }

    /**
     * Set the value of Borrower
     *
     * @param mixed borrower
     *
     * @return self
     */
    public function setBorrower($borrower)
    {
        $this->borrower = $borrower;

        return $this;
    }

    /**
     * Get the value of Borrow Date
     *
     * @return mixed
     */
    public function getBorrowDate()
    {
        return $this->borrowDate;
    }

    /**
     * Set the value of Borrow Date
     *
     * @param mixed borrowDate
     *
     * @return self
     */
    public function setBorrowDate($borrowDate)
    {
        $this->borrowDate = $borrowDate;

        return $this;
    }

    /**
     * Get the value of Borrow Comment
     *
     * @return mixed
     */
    public function getBorrowComment()
    {
        return $this->borrowComment;
    }

    /**
     * Set the value of Borrow Comment
     *
     * @param mixed borrowComment
     *
     * @return self
     */
    public function setBorrowComment($borrowComment)
    {
        $this->borrowComment = $borrowComment;

        return $this;
    }

    /**
     * Get the value of Private
     *
     * @return mixed
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * Set the value of Private
     *
     * @param mixed private
     *
     * @return self
     */
    public function setPrivate($private)
    {
        $this->private = $private;

        return $this;
    }

    /**
     * Get the value of Category
     *
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of Category
     *
     * @param mixed category
     *
     * @return self
     */
    public function setCategory($category)
    {
        $this->category = $category;

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
