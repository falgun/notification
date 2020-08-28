<?php
declare(strict_types=1);

namespace Falgun\Notification;

use Falgun\Http\Session;
use Falgun\Notification\Notes\BootstrapNote;
use Falgun\Notification\Notes\NoteInterface;

class Notification implements NotificationInterface
{

    const FLASH_NOTE_KEY = 'falgun_flash_notifications';

    protected Session $session;
    protected string $noteClass;

    public function __construct(Session $session, string $noteClass = BootstrapNote::class)
    {
        $this->session = $session;
        $this->noteClass = $noteClass;
    }

    public function setNotifications(array $notifications): void
    {
        $this->session->set(self::FLASH_NOTE_KEY, $notifications);
    }

    public function getNotifications(): array
    {
        if ($this->session->has(self::FLASH_NOTE_KEY)) {
            return $this->session->get(self::FLASH_NOTE_KEY);
        }

        return [];
    }

    public function hasNotification(): bool
    {
        return $this->session->has(self::FLASH_NOTE_KEY);
    }

    public function removeNotifications(): void
    {
        $this->session->remove(self::FLASH_NOTE_KEY);
    }

    public function countNotification(): int
    {
        return \count($this->getNotifications());
    }

    public function setNote(NoteInterface $note): bool
    {
        $notifications = $this->getNotifications();
        $notifications[] = $note;
        $this->setNotifications($notifications);

        return $this->hasNotification();
    }

    public function flashNotifications(): array
    {
        if ($this->hasNotification() !== true) {
            return [];
        }

        $notifications = $this->getNotifications();

        $this->removeNotifications();

        return $notifications;
    }

    public function noteFactory(): NoteInterface
    {
        $note = new $this->noteClass();

        if (!$note instanceof NoteInterface) {
            throw new \RuntimeException($this->noteClass . ' must implement ' . NoteInterface::class);
        }

        return $note;
    }

    public function successNote(string $message): void
    {
        $note = $this->noteFactory();
        $note->message = $message;
        $note->markAsSuccess();

        $this->setNote($note);
    }

    public function warningNote(string $message): void
    {
        $note = $this->noteFactory();
        $note->message = $message;
        $note->markAsWarning();

        $this->setNote($note);
    }

    public function errorNote(string $message): void
    {
        $note = $this->noteFactory();
        $note->message = $message;
        $note->markAsError();

        $this->setNote($note);
    }
}