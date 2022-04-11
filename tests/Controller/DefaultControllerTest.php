<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * Test the redirect when the unauthenticated user requests the homepage.
     */
    public function testUnauthenticatedUserHomepage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseRedirects('http://localhost/login');
    }

    /**
     * Test the redirect to homepage while logged in.
     */
    public function testVisitingWhileLoggedIn(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !');
    }
}
