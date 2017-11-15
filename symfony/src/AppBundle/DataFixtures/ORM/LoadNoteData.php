<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Note;

class LoadNoteData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $note1 = new Note;
        $note1->setBook($this->getReference('Harry Potter'));
        $note1->setUser($this->getReference('Ben'));
        $note1->setNote(5);
        $manager->persist($note1);

        $note2 = new Note;
        $note2->setBook($this->getReference('Harry Potter'));
        $note2->setUser($this->getReference('Oclock'));
        $note2->setNote(3);
        $manager->persist($note2);

        // Test pour non duplication de la relation avec clé composite
        // $note3 = new Note;
        // $note3->setBook($this->getReference('Harry Potter'));
        // $note3->setUser($this->getReference('Oclock'));
        // $note3->setNote(3);
        // $manager->persist($note3);

        $manager->flush();
    }

    public function getOrder()
    {
        return 8;
    }
}
