<?php
declare(strict_types=1);

namespace Falgun\Notification\Tests;

use Falgun\Notification\Notification;
use Falgun\Notification\Notes\BootstrapNote;
use Falgun\Notification\Notes\SimpleNote;
use PHPUnit\Framework\TestCase;

class NotificationTest extends TestCase
{

    public function testNotification()
    {
        $session = new MockSession();

        $notification = new Notification($session, SimpleNote::class);

        $notification->successNote('Oh Yeah');
        $notification->warningNote('Oh ho');
        $notification->errorNote('hold up');


        $this->assertEquals(3, $notification->countNotification());
        $this->assertEquals(true, $notification->hasNotification());


        $successNote = new SimpleNote('Oh Yeah');
        $successNote->setType(SimpleNote::TYPE_SUCCESS);

        $warningNote = new SimpleNote('Oh ho');
        $warningNote->setType(SimpleNote::TYPE_WARNING);

        $errorNote = new SimpleNote('hold up');
        $errorNote->setType(SimpleNote::TYPE_ERROR);


        $this->assertEquals(
            [$successNote, $warningNote, $errorNote],
            $notification->getNotifications()
        );

        $this->assertEquals(NULL, $notification->removeNotifications());
        $this->assertEquals(false, $notification->hasNotification());
        $this->assertEquals(0, $notification->countNotification());
        $this->assertEquals([], $notification->getNotifications());
        $this->assertEquals(NULL, $notification->setNotifications([$successNote]));
        $this->assertEquals([$successNote], $notification->flashNotifications());
        $this->assertEquals(false, $notification->hasNotification());
    }

    public function testEmptyNotification()
    {
        $session = new MockSession();

        $notification = new Notification($session, SimpleNote::class);

        $this->assertSame([], $notification->flashNotifications());
    }

    public function testInvalidNoteClass()
    {
        $session = new MockSession();

        $notification = new Notification($session, self::class);
        try {
            $note = $notification->noteFactory('Demo Message');
            $this->fail();
        } catch (\RuntimeException $e) {
            $this->assertEquals(
                'Falgun\Notification\Tests\NotificationTest must implement Falgun\Notification\Notes\NoteInterface',
                $e->getMessage());
        }
    }

    public function testErrorByDefault()
    {
        $message = 'we are testing default';

        $simpleNote = new SimpleNote($message);
        $jsonNote = new \Falgun\Notification\Notes\JsonNote($message);
        $bootstrapNote = new BootstrapNote($message);

        $this->assertSame($message, $simpleNote->getMessage());
        $this->assertSame('error', $simpleNote->getType());

        $this->assertSame($message, $jsonNote->getMessage());
        $this->assertSame('error', $jsonNote->getType());

        $this->assertSame($message, $bootstrapNote->getMessage());
        $this->assertSame('danger', $bootstrapNote->getType());
    }
}
