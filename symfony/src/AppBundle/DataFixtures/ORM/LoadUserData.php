<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user1 = new User;
        $user1->setUsername('Ben');
        $user1->setPassword('$2y$10$kR0f37Y7U.Dzhf48uWbrkeWWhPvpicQEllHNi/Timitrn7rq9c1uK');
        $user1->setEmail('ben@test.com');
        $user1->setAddress('La Rochelle, France');
        $user1->setLat(46.160329);
        $user1->setLng(-1.1511390000000574);
        $user1->setEnabled(true);
        $user1->addRole('ROLE_ADMIN');
        $manager->persist($user1);

        $user2 = new User;
        $user2->setUsername('Oclock');
        $user2->setPassword('$2y$10$FBp0VXXxcy9HFN82mzPcSe6Q7k0/u63/lp2AYTmKZeBn0dHd32m6m');
        $user2->setEmail('oclock@test.com');
        $user2->setAddress('Paris, France');
        $user2->setLat(48.856614);
        $user2->setLng(2.3522219000000177);
        $user2->setEnabled(true);
        $manager->persist($user2);

        $user3 = new User;
        $user3->setUsername('Django');
        $user3->setPassword('$2y$10$FBp0VXXxcy9HFN82mzPcSe6Q7k0/u63/lp2AYTmKZeBn0dHd32m6m');
        $user3->setEmail('django@test.com');
        $user3->setAddress('Paris, France');
        $user3->setLat(48.856614);
        $user3->setLng(2.3522219000000177);
        $user3->setEnabled(true);
        $manager->persist($user3);

        $manager->flush();

        $this->addReference('Ben', $user1);
        $this->addReference('Oclock', $user2);
        $this->addReference('Django', $user3);
    }

    public function getOrder()
    {
        return 1;
    }
}
