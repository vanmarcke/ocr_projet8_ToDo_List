<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Load user fixtures to database.
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; ++$i) {
            $user = new User();
            $user->setEmail('user'.$i.'@gmail.com')
                ->setUsername('user'.$i)
                ->setPassword($this->encoder->hashPassword($user, '123456'));

            $manager->persist($user);
        }

        $admin = new User();
        $admin->setEmail('admin@gmail.com')
            ->setUsername('admin')
            ->setPassword($this->encoder->hashPassword($user, '123456'))
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $manager->flush();
    }
}
