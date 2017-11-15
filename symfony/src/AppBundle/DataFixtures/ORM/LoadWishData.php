<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\User;

class LoadWishData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->getReference('Ben')->addBookwish($this->getReference('Bilbo'));

        $manager->flush();
    }

    public function getOrder()
    {
        return 6;
    }
}
