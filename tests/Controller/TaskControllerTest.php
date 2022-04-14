<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskControllerTest extends WebTestCase
{
    /**
     * Test redirecting to the To-Do List page when logged in.
     */
    public function testVisitToDoListWhileLoggedIn(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', '/tasks/todo');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Liste des tâches à faire');
    }

    /**
     * Test redirecting to the Completed Tasks List page when logged in.
     */
    public function testVisitCompletedListWhileLoggedIn(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', '/tasks/done');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Liste des tâches terminées');
    }

    /**
     * Test integration of task creation page for authenticated user.
     */
    public function testDisplayOfTheTaskCreationPage(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('user1@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/tasks/create');

        $this->assertSame(1, $crawler->filter('a:contains("Se déconnecter")')->count());
        $this->assertSame(1, $crawler->filter('a:contains("Retour à la liste des tâches")')->count());
        $this->assertSelectorExists('form');
        $this->assertCount(2, $crawler->filter('input'));
        $this->assertCount(1, $crawler->filter('textarea'));
        $this->assertSame(1, $crawler->filter('html:contains("Title")')->count());
        $this->assertSame(1, $crawler->filter('html:contains("Content")')->count());
        $this->assertSame(1, $crawler->filter('button:contains("Ajouter")')->count());
    }

    /**
     * Test new task creation.
     */
    public function testNewTaskCreation()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('user1@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'New Task';
        $form['task[content]'] = 'New content';
        $client->submit($form);

        $this->assertResponseRedirects('/tasks/todo');
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertSame(1, $crawler->filter('h4 a:contains("New Task")')->count());
        $this->assertSame(1, $crawler->filter('p:contains("New content")')->count());
        $this->assertSame(0, $crawler->filter('h6:contains("Auteur: Anonyme")')->count());
    }

    /**
     * Test integration of task edition page for authenticated user.
     */
    public function testIntegrationTaskEditionPage()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('user1@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/tasks/1/edit');

        $this->assertSame(1, $crawler->filter('a:contains("Se déconnecter")')->count());
        $this->assertSelectorExists('a', 'Retour à la liste des tâches');
        $this->assertSelectorExists('form');
        $this->assertSame(1, $crawler->filter('label:contains("Content")')->count());
        $this->assertSame(1, $crawler->filter('input[value="Titre de la tache 1"]')->count());
        $this->assertSelectorExists('button', 'Modifier');
        $this->assertInputValueNotSame('task[title]', '');
    }

    /**
     * Test task edition.
     */
    public function testTaskEdition()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('user1@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/tasks/1/edit');

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'new title';
        $form['task[content]'] = 'new content';
        $client->submit($form);

        $this->assertResponseRedirects('/tasks/todo');
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }

    /**
     * Test toggle action - set task6 is_done to true.
     */
    public function testToggleActionSetIsDone()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('user1@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/tasks/6/toggle');
        $this->assertResponseRedirects('/tasks/todo');
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertSelectorNotExists('#task6');
    }

    /**
     * Test toggle action - set task3 is_done to false.
     */
    public function testToggleActionSetIsNotDone()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('user1@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/tasks/3/toggle');
        $this->assertResponseRedirects('/tasks/todo');

        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertSelectorExists('#task3 .glyphicon-remove');
        $this->assertSelectorNotExists('#task3 .glyphicon-ok');
    }

    /**
     * Test deleting a task.
     */
    public function testDeleteTask()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('POST', '/tasks/4/delete');
        $this->assertResponseRedirects('/tasks/todo');
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertSelectorNotExists('#task4');
    }

    /**
     * Test the 404 error response when performing an action with a resource that does not exist.
     */
    public function testTaskActionDoesNotExist()
    {
        $routes = [
            ['GET', '/tasks/20/edit'],
            ['GET', '/tasks/20/toggle'],
            ['DELETE', '/tasks/20/delete'],
        ];
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('user1@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        foreach ($routes as $route) {
            $client->request($route[0], $route[1]);
            $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        }
    }
}
