<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *@ORM\Entity
 *@ORM\Table(name="category")
 */
class Category
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
    private $categoryName;

    /**
     * @ORM\OneToMany(targetEntity="Collection", mappedBy="category")
     */
    private $collections;

    public function __construct()
    {
        $this->collections = new ArrayCollection;
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
     * Get the value of Category Name
     *
     * @return mixed
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    /**
     * Set the value of Category Name
     *
     * @param mixed categoryName
     *
     * @return self
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;

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
        $this->collections[] = $collection;

        return $this;
    }

    public function removeCollection(Collection $collection)
    {
        $this->collections->removeElement($collection);
    }

    public function __toString() {
        return $this->getCategoryName();
    }
}
