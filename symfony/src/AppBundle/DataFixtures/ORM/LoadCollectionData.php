<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Collection;

class LoadCollectionData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $collection1 = new Collection;
        $collection1->setBook($this->getReference('Tintin'));
        $collection1->setUser($this->getReference('Ben'));
        $collection1->setCategory($this->getReference('BD'));
        $manager->persist($collection1);

        $collection2 = new Collection;
        $collection2->setBook($this->getReference('Harry Potter'));
        $collection2->setUser($this->getReference('Ben'));
        $collection2->setCategory($this->getReference('Fantastique'));
        $manager->persist($collection2);

        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }
}
