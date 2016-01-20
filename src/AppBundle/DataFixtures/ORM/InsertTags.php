<?php
/**
 * Created by PhpStorm.
 * User: sebas
 * Date: 12/31/2015
 * Time: 2:08 PM
 */

namespace AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Tag;
use AppBundle\Entity\Topic;

class InsertTags implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $tag = new Tag();
        $tag->setTitle('Frontend');
        $tag->setDescription('CSS and JS');
        $manager->persist($tag);
        $manager->flush();

        $tag = new Tag();
        $tag->setTitle('Backend');
        $tag->setDescription('PHP / C# / Java asf.');
        $manager->persist($tag);
        $manager->flush();

        $tag = new Tag();
        $tag->setTitle('Framework');
        $tag->setDescription('Symfony / Zend / Movico');
        $manager->persist($tag);
        $manager->flush();

        $tag = new Tag();
        $tag->setTitle('Empty Tag');
        $tag->setDescription('Empty / Tag');
        $manager->persist($tag);
        $manager->flush();


//        $userAdmin = new User();
//        $userAdmin->setUsername('admin');
//        $userAdmin->setPassword('test');
//
//        $manager->persist($userAdmin);
//        $manager->flush();
    }
}
