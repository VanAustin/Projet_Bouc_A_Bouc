<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *@ORM\Entity
 *@ORM\Table(name="book")
 *@ORM\Entity(repositoryClass="AppBundle\Repository\BookRepository")
 */
class Book
{
    /**
     *@ORM\Column(type="integer")
     *@ORM\Id
     *@ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $pageCount;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @JMS\Serializer\Annotation\Type("DateTime<'Y-m-d'>");
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $editor;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="decimal", precision=13)
     */
    private $isbn13;

    /**
     * @ORM\Column(type="decimal", precision=10)
     */
    private $isbn10;

    /**
     * @ORM\OneToMany(targetEntity="Collection", mappedBy="book", cascade={"persist"})
     */
    private $collections;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="book", cascade={"persist"})
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="Note", mappedBy="book", cascade={"persist"})
     */
    private $notes;

    /**
     * @ORM\ManyToMany(targetEntity="Author", inversedBy="books")
     */
    private $authors;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="bookwishes")
     */
    private $userwishes;

    public function __construct()
    {
        $this->collections = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->authors = new ArrayCollection();
        $this->userwishes = new ArrayCollection();
    }

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
     * Get the value of Title
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of Title
     *
     * @param mixed title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of Description
     *
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of Description
     *
     * @param mixed description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of Page Count
     *
     * @return mixed
     */
    public function getPageCount()
    {
        return $this->pageCount;
    }

    /**
     * Set the value of Page Count
     *
     * @param mixed pageCount
     *
     * @return self
     */
    public function setPageCount($pageCount)
    {
        $this->pageCount = $pageCount;

        return $this;
    }

    /**
     * Get the value of Published At
     *
     * @return mixed
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * Set the value of Published At
     *
     * @param mixed publishedAt
     *
     * @return self
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * Get the value of Editor
     *
     * @return mixed
     */
    public function getEditor()
    {
        return $this->editor;
    }

    /**
     * Set the value of Editor
     *
     * @param mixed editor
     *
     * @return self
     */
    public function setEditor($editor)
    {
        $this->editor = $editor;

        return $this;
    }

    /**
     * Get the value of Picture
     *
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of Picture
     *
     * @param mixed picture
     *
     * @return self
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get the value of Isbn
     *
     * @return mixed
     */
    public function getIsbn13()
    {
        return $this->isbn13;
    }

    /**
     * Set the value of Isbn
     *
     * @param mixed isbn13
     *
     * @return self
     */
    public function setIsbn13($isbn13)
    {
        $this->isbn13 = $isbn13;

        return $this;
    }

    /**
     * Get the value of Isbn
     *
     * @return mixed
     */
    public function getIsbn10()
    {
        return $this->isbn10;
    }

    /**
     * Set the value of Isbn
     *
     * @param mixed isbn10
     *
     * @return self
     */
    public function setIsbn10($isbn10)
    {
        $this->isbn10 = $isbn10;

        return $this;
    }

    /**
     * Get the value of Collections
     *
     * @return mixed
     */
    public function getCollections()
    {
        return $this->collections;
    }

    public function addCollection(Collection $collection)
    {
        $collection->setBook($this);
        $this->collections[] = $collection;
    }

    public function removeCollection(Collection $collection)
    {
        $this->collections->removeElement($collection);
    }

    /**
     * Get the value of Comments
     *
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    public function addComment(Comment $comment)
    {
        $comment->setBook($this);
        $this->comments[] = $comment;
    }

    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get the value of Notes
     *
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    public function addNote(Note $note)
    {
        $note->setBook($this);
        $this->notes[] = $note;
    }

    public function removeNote(Note $note)
    {
        $this->notes->removeElement($note);
    }

    /**
     * Get the value of Authors
     *
     * @return mixed
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    public function addAuthor(Author $author)
    {
        $author->addBook($this);
        $this->authors[] = $author;
    }

    public function removeAuthor(Author $author)
    {
        $author->removeBook($this);
        $this->authors->removeElement($author);
    }

    /**
     * Get the value of Userwishes
     *
     * @return mixed
     */
    public function getUserwishes()
    {
        return $this->userwishes;
    }

    public function addUserwish(User $user)
    {
        $this->userwishes[] = $user;
    }

    public function removeUserwish(User $user)
    {
        $this->userwishes->removeElement($user);
    }

    public function __toString() {
        return $this->getTitle();
    }
}
