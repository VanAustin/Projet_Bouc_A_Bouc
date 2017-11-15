<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Friend;

class LoadFriendData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $friend1 = new Friend;
        $friend1->setUser($this->getReference('Ben'));
        $friend1->setHasfriend($this->getReference('Oclock'));
        $friend1->setAccepted(true);
        $manager->persist($friend1);

        $friend2 = new Friend;
        $friend2->setUser($this->getReference('Oclock'));
        $friend2->setHasfriend($this->getReference('Ben'));
        $friend2->setAccepted(true);
        $manager->persist($friend2);

        // Test pour non duplication de la relation avec clé composite
        // $friend3 = new Friend;
        // $friend3->setUser($this->getReference('Oclock'));
        // $friend3->setHasfriend($this->getReference('Ben'));
        // $friend3->setAccepted(true);
        // $manager->persist($friend3);

        $manager->flush();
    }

    public function getOrder()
    {
        return 9;
    }
}
