<?php

namespace App\DataFixtures;

use App\Entity\Companies;
use App\Entity\Projects;
use App\Entity\Workers;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $workers1 = new Workers();
        $workers1->setName('Paul');


        $manager->persist($workers1);

        $workers2 = new Workers();
        $workers2->setName('Franck');

        $manager->persist($workers2);

        $workers3 = new Workers();
        $workers3->setName('Jean');

        $manager->persist($workers3);

        $workers4 = new Workers();
        $workers4->setName('Abdoul');

        $manager->persist($workers4);


        $workers5 = new Workers();
        $workers5->setName('Gérard');


        $manager->persist($workers5);

        $workers6 = new Workers();
        $workers6->setName('Mehdi');


        $manager->persist($workers6);

        $workers7 = new Workers();
        $workers7->setName('Margaux');


        $manager->persist($workers7);

        $workers8 = new Workers();
        $workers8->setName('Marine');


        $manager->persist($workers8);



        $project1 = new Projects();
        $project1
            ->setName('Nouvelle HomePage')
            ->setPriceSold(10000)
            ->settype('evolution')
            ->setEstimatedTime(15)
            ->setSpentTime(12)
            ->setTechnology("Symfony")
            ->addWorker($workers1)
            ->addWorker($workers2);


        $manager->persist($project1);

        $project2 = new Projects();
        $project2
            ->setName('Refonte Site')
            ->setPriceSold(250000)
            ->settype('redesign')
            ->setEstimatedTime(358)
            ->setSpentTime(246)
            ->setTechnology("Symfony")
            ->addWorker($workers3)
            ->addWorker($workers4)
            ->addWorker($workers5)
            ->addWorker($workers6);
        $manager->persist($project2);

        $project3 = new Projects();
        $project3
            ->setName('Panier V2')
            ->setPriceSold(40000)
            ->settype('evolution')
            ->setEstimatedTime(57)
            ->setSpentTime(2)
            ->setTechnology("Symfony")
            ->addWorker($workers1)
            ->addWorker($workers8);
        $manager->persist($project3);


        $project4 = new Projects();
        $project4
            ->setName('Panier V2')
            ->setPriceSold(5000)
            ->settype('maintenance')
            ->setEstimatedTime(7)
            ->setSpentTime(1)
            ->setTechnology("Symfony")
            ->addWorker($workers4)
            ->addWorker($workers6);
        $manager->persist($project4);

        $compagny1 = new Companies();
        $compagny1->setName('Google')
            ->addProject($project1);

        $manager->persist($compagny1);

        $compagny2 = new Companies();
        $compagny2->setName('Amazon')
            ->addProject($project2)
            ->addProject($project3)
            ->addProject($project4);

        $manager->persist($compagny2);

        $manager->flush();
    }
}
