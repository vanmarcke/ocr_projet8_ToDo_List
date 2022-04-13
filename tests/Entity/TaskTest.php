<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use DateTime;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    /**
     * Test inserting a CreatedAt.
     */
    public function testValidSetCreatedAt(): void
    {
        $task = new Task();
        $createdAtExpected = new DateTime('2022-04-13');
        $task->setCreatedAt($createdAtExpected);
        $this->assertEquals($createdAtExpected, $task->getCreatedAt());
        $this->assertNotNull($task->getCreatedAt());
    }

    /**
     * Test reading a CreatedAt.
     */
    public function testValidGetCreatedAt(): void
    {
        $task = new Task();
        $createdAtExpected = new DateTime('2022-04-13');
        $task->setCreatedAt($createdAtExpected);
        $this->assertEquals($createdAtExpected, $task->getCreatedAt());
    }

    /**
     * Test inserting a title.
     */
    public function testSetTitle(): void
    {
        $task = new Task();
        $titleExpected = 'title';
        $task->setTitle($titleExpected);
        $actualTitle = $task->getTitle();
        $this->assertEquals($titleExpected, $actualTitle);
        $this->assertNotNull($actualTitle);
    }

    /**
     * Test reading a title.
     */
    public function testValidGetTitle(): void
    {
        $task = new Task();
        $titleExpected = 'title';
        $task->setTitle($titleExpected);
        $this->assertEquals($titleExpected, $task->getTitle());
    }

    /**
     * Test inserting a content.
     */
    public function testValidSetContent(): void
    {
        $task = new Task();
        $contentExpected = 'content';
        $task->setContent($contentExpected);
        $this->assertEquals($contentExpected, $task->getContent());
        $this->assertNotNull($task->getContent());
    }

    /**
     * Test reading a content.
     */
    public function testValidGetContent(): void
    {
        $task = new Task();
        $contentExpected = 'content';
        $task->setContent($contentExpected);
        $this->assertEquals($contentExpected, $task->getContent());
    }

    /**
     * Test inserting a IsDone.
     */
    public function testValidSetIsDone(): void
    {
        $task = new Task();
        $isDoneExpected = true;
        $task->setIsDone($isDoneExpected);
        $this->assertEquals($isDoneExpected, $task->getIsDone());
        $this->assertNotNull($task->getIsDone());
    }

    /**
     * Test reading a content.
     */
    public function testValidGetIsDone(): void
    {
        $task = new Task();
        $isDoneExpected = false;
        $task->setIsDone($isDoneExpected);
        $this->assertEquals($isDoneExpected, $task->getIsDone());
    }

    /**
     * Test toggle method from Task entity.
     */
    public function testToggle(): void
    {
        $task = new Task();
        $toggleExpected = $task;
        $task->toggle(!$toggleExpected->isDone());
        $this->assertTrue($toggleExpected->isDone());
    }
}
