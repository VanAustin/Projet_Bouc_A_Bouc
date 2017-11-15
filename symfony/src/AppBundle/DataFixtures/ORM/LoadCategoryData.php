<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $category1 = new Category;
        $category1->setCategoryName('BD');
        $manager->persist($category1);

        $category2 = new Category;
        $category2->setCategoryName('Fantastique');
        $manager->persist($category2);

        $manager->flush();

        $this->addReference('BD', $category1);
        $this->addReference('Fantastique', $category2);
    }

    public function getOrder()
    {
        return 4;
    }
}
