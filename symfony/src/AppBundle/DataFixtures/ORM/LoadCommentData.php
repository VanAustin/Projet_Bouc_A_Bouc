<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Comment;

class LoadCommentData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $comment1 = new Comment;
        $comment1->setBook($this->getReference('Harry Potter'));
        $comment1->setUser($this->getReference('Ben'));
        $comment1->setText('Très bon livre, se lit trop rapidement !');
        $comment1->setPublishedAt(new \DateTime('2017-10-04'));
        $manager->persist($comment1);

        $comment2 = new Comment;
        $comment2->setBook($this->getReference('Harry Potter'));
        $comment2->setUser($this->getReference('Oclock'));
        $comment2->setText('Trop enfantin à mon goût...');
        $comment2->setPublishedAt(new \DateTime('2017-10-04'));
        $manager->persist($comment2);

        $comment3 = new Comment;
        $comment3->setBook($this->getReference('Harry Potter'));
        $comment3->setUser($this->getReference('Oclock'));
        $comment3->setText('Mais immersion réussie :)');
        $comment3->setPublishedAt(new \DateTime('2017-10-04'));
        $manager->persist($comment3);

        $manager->flush();
    }

    public function getOrder()
    {
        return 7;
    }
}
