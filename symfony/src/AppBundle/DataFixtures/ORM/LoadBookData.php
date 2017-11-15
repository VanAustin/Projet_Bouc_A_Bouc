<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Book;

class LoadBookData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $book1 = new Book;
        $book1->setTitle('Tintin et les Picaros');
        $book1->setDescription('Tintin et les Picaros ramène Tintin sur les lieux de l’une de ses plus anciennes aventures, le San Theodoros, ce petit état latino-américain que se disputent le général Alcazar et son éternel rival, le général Tapioca. Celui-ci a fait arrêter la Castafiore et les Dupondt au cours d’un voyage sur place, au motif qu’ils seraient les agents d’un complot fomenté par Haddock pour renverser le régime et porter Alcazar au pouvoir. Haddock et Tournesol, suivis un peu plus tard de Tintin, prennent le chemin du San Theodoros dans l’espoir de faire libérer leurs amis.');
        $book1->setPageCount(62);
        $book1->setPublishedAt(new \DateTime('2007-01-01'));
        $book1->setEditor('undefined');
        $book1->setPicture('http://books.google.com/books/content?id=K4v7IAAACAAJ&printsec=frontcover&img=1&zoom=1&source=gbs_api');
        $book1->setIsbn13(9782203007673);
        $book1->setIsbn10(2203007672);
        $book1->addAuthor($this->getReference('Hergé'));
        $manager->persist($book1);

        $book2 = new Book;
        $book2->setTitle('Harry Potter et la Chambre des Secrets');
        $book2->setDescription('Une rentrée fracassante en voiture volante, une étrange malédiction qui s’abat sur les élèves, cette deuxième année à l’école des sorciers ne s’annonce pas de tout repos! Entre les cours de potions magiques, les matches de Quidditch et les combats de mauvais sorts, Harry et ses amis Ron et Hermione trouveront-ils le temps de percer le mystère de la Chambre des Secrets? Le deuxiè me volume des aventures de Harry Potter : un livre magique pour sorciers confirmés.');
        $book2->setPageCount(364);
        $book2->setPublishedAt(new \DateTime('2015-12-08'));
        $book2->setEditor('Pottermore');
        $book2->setPicture('http://books.google.com/books/content?id=GBl6MWssicEC&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api');
        $book2->setIsbn13(9781781101049);
        $book2->setIsbn10(1781101043);
        $book2->addAuthor($this->getReference('JK Rowling'));
        $manager->persist($book2);

        $book3 = new Book;
        $book3->setTitle('Bilbo le Hobbit');
        $book3->setDescription('Bilbo, comme tous les hobbits, est un petit être paisible qui n\'aime pas être dérangé quand il est à table. L\'aventure tombe chez lui comme la foudre : un magicien et treize nains barbus viennent lui parler de dragon, de trésor et d\'expédition périlleuse au-delà des montagnes. Le miracle, c\'est qu\'il les suivra et qu\'il affrontera tous les dangers, sans jamais perdre son humour, même s\'il tremble plus d\'une fois !');
        $book3->setPageCount(399);
        $book3->setPublishedAt(new \DateTime('1983-01-01'));
        $book3->setEditor('Hachette Book Group USA');
        $book3->setPicture('http://books.google.com/books/content?id=uBLfNAEACAAJ&printsec=frontcover&img=1&zoom=1&source=gbs_api');
        $book3->setIsbn13(9782010199073);
        $book3->setIsbn10(2010199073);
        $book3->addAuthor($this->getReference('Tolkien'));
        $manager->persist($book3);

        $manager->flush();

        $this->addReference('Tintin', $book1);
        $this->addReference('Harry Potter', $book2);
        $this->addReference('Bilbo', $book3);
    }

    public function getOrder()
    {
        return 3;
    }
}
