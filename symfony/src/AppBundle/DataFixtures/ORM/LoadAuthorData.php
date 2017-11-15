<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Author;

class LoadAuthorData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $author1 = new Author;
        $author1->setAuthorName('J.K. Rowling');
        $manager->persist($author1);

        $author2 = new Author;
        $author2->setAuthorName('Hergé');
        $manager->persist($author2);

        $author3 = new Author;
        $author3->setAuthorName('John Ronald Reuel Tolkien');
        $manager->persist($author3);

        $manager->flush();

        $this->addReference('JK Rowling', $author1);
        $this->addReference('Hergé', $author2);
        $this->addReference('Tolkien', $author3);
    }

    public function getOrder()
    {
        return 2;
    }
}
