<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    /**
     * Test User list page integration for an authenticated user.
     */
    public function testUserListPageIntegrationForAnAuthenticatedUserLikeAdmin()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/users');
        $this->assertSame(1, $crawler->filter('a:contains("Créer un utilisateur")')->count());
        $this->assertSelectorTextSame('h1', 'Liste des utilisateurs');
        $this->assertSelectorExists('table');
        $this->assertSame(1, $crawler->filter('th:contains("Nom d\'utilisateur")')->count());
        $this->assertSame(1, $crawler->filter('th:contains("Adresse d\'utilisateur")')->count());
        $this->assertSame(1, $crawler->filter('th:contains("Actions")')->count());
        $this->assertGreaterThanOrEqual(1, $crawler->filter('a:contains("Edit")')->count());
    }

    /**
     * Test validity of create user link.
     */
    public function testValidCreateUserLinkUsersPage()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/users');
        $link = $crawler->selectLink('Créer un utilisateur')->link();
        $crawler = $client->click($link);
        $this->assertSelectorTextSame('h1', 'Créer un utilisateur');
    }

    /**
     * Test integration of user creation page.
     */
    public function testIntegrationUserCreationPage()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/users/create');
        $this->assertSelectorTextSame('h1', 'Créer un utilisateur');
        $this->assertSelectorExists('form');
        $this->assertCount(5, $crawler->filter('label'));
        $this->assertCount(5, $crawler->filter('input'));
        $this->assertCount(1, $crawler->filter('select'));
        $this->assertSelectorTextSame('button', 'Ajouter');
    }

    /**
     * Test creating a new user.
     */
    public function testUserCreationByAdmin()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'newuser';
        $form['user[password][first]'] = 'newpassword';
        $form['user[password][second]'] = 'newpassword';
        $form['user[email]'] = 'newemail@email.com';
        $form['user[roles]'] = 'ROLE_ADMIN';
        $client->submit($form);

        $this->assertResponseStatusCodeSame(302);
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertSelectorTextSame('h1', 'Liste des utilisateurs');
        $this->assertSame(1, $crawler->filter('td:contains("newuser")')->count());
        $this->assertSame(1, $crawler->filter('td:contains("newemail@email.com")')->count());
        $this->assertSame(2, $crawler->filter('td:contains("Admin")')->count());
    }

    /**
     * Test the edit user link.
     */
    public function testValidEditUserLinkUsersPage()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/users');
        $link = $crawler->selectLink('Edit')->link();
        $crawler = $client->click($link);
        $this->assertSame(1, $crawler->filter('h1:contains("Modifier")')->count());
    }

    /**
     * Test valid user edition.
     */
    public function testValidUserEdition()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/users/1/edit');

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'newuser1';
        $form['user[email]'] = 'newemail1@email.com';
        $form['user[password][first]'] = 'newpass';
        $form['user[password][second]'] = 'newpass';
        $form['user[roles]'] = 'ROLE_ADMIN';
        $client->submit($form);

        $this->assertResponseRedirects('/users');
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertSame(1, $crawler->filter('td:contains("newuser1")')->count());
        $this->assertSame(1, $crawler->filter('td:contains("newemail1@email.com")')->count());
        $this->assertSame(1, $crawler->filter('td:contains("Admin")')->count());
    }

    /**
     * Test invalid user edition.
     */
    public function testInvalidUserEdition()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/users/1/edit');

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'user1';
        $form['user[email]'] = 'user1@email.com';
        $form['user[password][first]'] = 'newpass';
        $form['user[password][second]'] = 'newpass';
        $crawler = $client->submit($form);

        $this->assertSame(1, $crawler->filter('h1:contains("Modifier")')->count());
        $this->assertSame(1, $crawler->filter('span:contains("Ce nom d\'utilisateur existe déjà.")')->count());
    }
}
