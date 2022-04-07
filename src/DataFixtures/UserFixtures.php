<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $encoder)
    {
    }

    /**
     * Load user fixtures to database.
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setEmail('admin@gmail.com')
            ->setUsername('admin')
            ->setPassword($this->encoder->hashPassword($admin, '123456'))
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        for ($i = 1; $i <= 5; ++$i) {
            $user = new User();
            $user->setEmail('user'.$i.'@gmail.com')
                ->setUsername('user'.$i)
                ->setPassword($this->encoder->hashPassword($user, '123456'));

            $manager->persist($user);
        }

        $manager->flush();
    }
}
