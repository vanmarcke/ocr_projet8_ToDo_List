<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * Test inserting a Username.
     */
    public function testValidSetUsername(): void
    {
        $user = new User();
        $usernameExpected = 'username';
        $user->setUsername($usernameExpected);
        $this->assertEquals($usernameExpected, $user->getUsername());
        $this->assertNotNull($user->getUsername());
    }

    /**
     * Test reading a Username.
     */
    public function testValidGetUsername(): void
    {
        $user = new User();
        $usernameExpected = 'username';
        $user->setUsername($usernameExpected);
        $this->assertEquals($usernameExpected, $user->getUsername());
    }

    /**
     * Test inserting a Password.
     */
    public function testValidSetPassword(): void
    {
        $user = new User();
        $passwordExpected = 'password';
        $user->setPassword($passwordExpected);
        $this->assertEquals($passwordExpected, $user->getPassword());
        $this->assertNotNull($user->getPassword());
    }

    /**
     * Test reading a Password.
     */
    public function testValidGetPassword(): void
    {
        $user = new User();
        $passwordExpected = 'password';
        $user->setPassword($passwordExpected);
        $this->assertEquals($passwordExpected, $user->getPassword());
    }

    /**
     * Test inserting a Email.
     */
    public function testValidSetEmail(): void
    {
        $user = new User();
        $emaildExpected = 'admin@gmail.com';
        $user->setEmail($emaildExpected);
        $this->assertEquals($emaildExpected, $user->getEmail());
        $this->assertNotNull($user->getEmail());
    }

    /**
     * Test reading a Email.
     */
    public function testValidGetEmail(): void
    {
        $user = new User();
        $emaildExpected = 'admin@gmail.com';
        $user->setEmail($emaildExpected);
        $this->assertEquals($emaildExpected, $user->getEmail());
    }

    /**
     * Test reading a Salt.
     */
    public function testValidGetSalt(): void
    {
        $user = new User();
        $saltdExpected = null;
        $this->assertEquals($saltdExpected, $user->getSalt());
    }

    /**
     * Test Get, adding and deleting a Task. (getTasks, addTask, removeTask).
     */
    public function testGetAddAndRemoveTask(): void
    {
        $user = new User();
        for ($i = 1; $i <= 5; ++$i) {
            $task = new Task();
            $task->setTitle('task' . $i)
                ->setContent('content' . $i)
                ->setAuthor($user);
            $user->addTask($task);
        }
        $tasks = $user->getTasks();
        $this->assertSame(5, \count($tasks));

        $user->removeTask($tasks[0]);
        $user->removeTask($tasks[1]);
        $this->assertSame(3, \count($tasks));
    }
}
