<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    /**
     * Test that the HTTP response was successful and that the request body contains the requested items.
     */
    public function testRequestBodyContains(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('form');
        $this->assertSelectorTextContains('a', 'To Do List app');
        $this->assertSame(1, $crawler->filter('html:contains("Nom d\'utilisateur :")')->count());
        $this->assertSame(1, $crawler->filter('html:contains("Mot de passe :")')->count());
        $this->assertCount(3, $crawler->filter('input'));
        $this->assertSelectorTextContains('button', 'Se connecter');
    }

    /**
     * Test the redirection when a user is logged in and try to go to the login page.
     */
    public function testRedirectionUserWhoIsAlreadyLoggedIn()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', '/login');
        $this->assertResponseRedirects('/');
    }
}
