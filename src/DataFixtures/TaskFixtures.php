<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 10; ++$i) {
            $task = new Task();
            $task->setTitle('Titre de la tache '.$i)
                ->setContent($faker->realText($maxNbChars = 200, $indexSize = 2));
                if ($i > 5) {
                    $task->setIsDone(false);
                } else {
                    $task->setIsDone(true);
                }

            $manager->persist($task);
        }

        $manager->flush();
    }
}
