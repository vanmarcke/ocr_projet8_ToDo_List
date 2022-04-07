<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 10; ++$i) {
            $task = new Task();
            $task->setTitle('Faire la tache '.$i)
                ->setContent($faker->text(mt_rand(50, 150)));
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
