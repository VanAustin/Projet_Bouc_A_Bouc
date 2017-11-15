<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use FOS\UserBundle\Model\User as BaseUser;

use Symfony\Component\HttpFoundation\File\File;
use VanTouch\UploadBundle\Annotation\Uploadable;
use VanTouch\UploadBundle\Annotation\UploadableField;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @Uploadable()
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="float", options={"default":0})
     */
    private $lat = 0;

    /**
     * @ORM\Column(type="float", options={"default":0})
     */
    private $lng = 0;

    /**
     * @ORM\OneToMany(targetEntity="Collection", mappedBy="user", cascade={"persist"})
     */
    private $collections;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="user", cascade={"persist"})
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="Note", mappedBy="user", cascade={"persist"})
     */
    private $notes;

    /**
     * @ORM\ManyToMany(targetEntity="Book", inversedBy="userwishes")
     */
    private $bookwishes;

    /**
     * @ORM\OneToMany(targetEntity="Friend", mappedBy="user", cascade={"persist"})
     */
    private $myfriends;

    /**
     * @ORM\OneToMany(targetEntity="Friend", mappedBy="hasFriend", cascade={"persist"})
     */
    private $friendswithme;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255, nullable=true)
     */
    private $filename;

    /**
     * @UploadableField(filename="filename", path="uploads")
     */
    private $file;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;


    public function __construct()
    {
        parent::__construct();
        $this->collections = new ArrayCollection;
        $this->comments = new ArrayCollection;
        $this->notes = new ArrayCollection;
        $this->bookwishes = new ArrayCollection;
        $this->myfriends = new ArrayCollection;
        $this->friendswithme = new ArrayCollection;
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
     * Get the value of Address
     *
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of Address
     *
     * @param mixed address
     *
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of Lat
     *
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set the value of Lat
     *
     * @param mixed lat
     *
     * @return self
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get the value of Lng
     *
     * @return mixed
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set the value of Lng
     *
     * @param mixed lng
     *
     * @return self
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

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
        $collection->setUser($this);
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
        $comment->setUser($this);
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
        $note->setUser($this);
        $this->notes[] = $note;
    }

    public function removeNote(Note $note)
    {
        $this->notes->removeElement($note);
    }

    /**
     * Get the value of Bookwishes
     *
     * @return mixed
     */
    public function getBookwishes()
    {
        return $this->bookwishes;
    }

    public function addBookwish(Book $book)
    {
        $book->addUserwish($this);
        $this->bookwishes[] = $book;
    }

    public function removeBookwish(Book $book)
    {
        $book->removeUserwish($this);
        $this->bookwishes->removeElement($book);
    }

    /**
     * Get the value of Myfriends
     *
     * @return mixed
     */
    public function getMyfriends()
    {
        return $this->myfriends;
    }

    public function addMyfriend(Friend $friend)
    {
        $friend->setUser($this);
        $this->myfriends[] = $user;
    }

    public function removeMyfriend(Friend $friend)
    {
        $this->myfriends->removeElement($friend);
    }

    /**
     * Get the value of Friendswithme
     *
     * @return mixed
     */
    public function getFriendswithme()
    {
        return $this->friendswithme;
    }

    public function addFriendwithme(Friend $friend)
    {
        $friend->setHasFriend($this);
        $this->friendswithme[] = $friend;
    }

    public function removeFriendwithle(Friend $friend)
    {
        $this->friendswithme->removeElement($friend);
    }

    public function __toString() {
        return $this->getUsername();
    }

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return User
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Get the value of File
     *
     * @return File|null
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set the value of File
     *
     * @param File file|null
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get the value of Updated At
     *
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of Updated At
     *
     * @param mixed updatedAt
     *
     * @return self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
