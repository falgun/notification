<?php
declare(strict_types=1);

namespace Falgun\Notification\Tests;

use Falgun\Notification\Notification;
use Falgun\Notification\Notes\BootstrapNote;
use Falgun\Notification\Notes\SimpleNote;
use Falgun\Notification\Notes\JsonNote;
use PHPUnit\Framework\TestCase;

class NotificationTypeTest extends TestCase
{

    public function testSuccessNote()
    {
        $session = new MockSession();

        $notification = new Notification($session);

        $message = 'Oh Yeah';

        $notification->successNote($message);

        /* @var $note BootstrapNote */
        $note = $notification->getNotifications()[0];

        $this->assertSame($message, $note->getMessage());
        $this->assertSame('success', $note->getType());
        $this->assertSame('check', $note->getIcon());
    }

    public function testWarningNote()
    {
        $session = new MockSession();

        $notification = new Notification($session);

        $message = 'Oh Yeah';

        $notification->warningNote($message);

        /* @var $note BootstrapNote */
        $note = $notification->getNotifications()[0];

        $this->assertSame($message, $note->getMessage());
        $this->assertSame('warning', $note->getType());
        $this->assertSame('exclamation-triangle', $note->getIcon());
    }

    public function testErrorNote()
    {
        $session = new MockSession();

        $notification = new Notification($session);

        $message = 'Oh Yeah';

        $notification->errorNote($message);

        /* @var $note BootstrapNote */
        $note = $notification->getNotifications()[0];

        $this->assertSame($message, $note->getMessage());
        $this->assertSame('danger', $note->getType());
        $this->assertSame('times', $note->getIcon());
    }

    public function testBootstrapNotification()
    {
        $session = new MockSession();

        $notification = new Notification($session);

        $notification->successNote('Oh Yeah');
        $notification->warningNote('eh he');
        $notification->errorNote('Oh No');

        $messages = $notification->flashNotifications();

        $note = new BootstrapNote('Oh Yeah');
        $note->setType(BootstrapNote::TYPE_SUCCESS);
        $note->setIcon('check');

        $note2 = new BootstrapNote('eh he');
        $note2->setType(BootstrapNote::TYPE_WARNING);
        $note2->setIcon('exclamation-triangle');

        $note3 = new BootstrapNote('Oh No');
        $note3->setType(BootstrapNote::TYPE_ERROR);
        $note3->setIcon('times');

        $this->assertEquals([$note, $note2, $note3,
            ], $messages);
    }
}
