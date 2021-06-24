<?php
declare(strict_types=1);

namespace Falgun\Notification;

use Falgun\Http\Session;
use Falgun\Notification\Notes\BootstrapNote;
use Falgun\Notification\Notes\NoteInterface;

class Notification implements NotificationInterface
{

    private const FLASH_NOTE_KEY = 'falgun_flash_notifications';

    protected Session $session;
    protected string $noteClass;

    /**
     * @param Session $session
     * @param class-string $noteClass
     */
    public function __construct(Session $session, string $noteClass = BootstrapNote::class)
    {
        $this->session = $session;
        $this->noteClass = $noteClass;
    }

    /**
     * @param array<int, NoteInterface> $notifications
     * @return void
     */
    public function setNotifications(array $notifications): void
    {
        $this->session->set(self::FLASH_NOTE_KEY, $notifications);
    }

    /**
     * get notifications from session
     * @return array<int, NoteInterface>
     *
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnStatement
     */
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

    /**
     * @return array<int, NoteInterface>
     */
    public function flashNotifications(): array
    {
        if ($this->hasNotification() !== true) {
            return [];
        }

        $notifications = $this->getNotifications();

        $this->removeNotifications();

        return $notifications;
    }

    /**
     * @param string $message
     * @return NoteInterface
     * @throws \RuntimeException
     * @psalm-suppress InvalidStringClass
     */
    public function noteFactory(string $message): NoteInterface
    {
        $note = new $this->noteClass($message);

        if (!$note instanceof NoteInterface) {
            throw new \RuntimeException($this->noteClass . ' must implement ' . NoteInterface::class);
        }

        return $note;
    }

    public function successNote(string $message): void
    {
        $note = $this->noteFactory($message);
        $note->markAsSuccess();

        $this->setNote($note);
    }

    public function warningNote(string $message): void
    {
        $note = $this->noteFactory($message);
        $note->markAsWarning();

        $this->setNote($note);
    }

    public function errorNote(string $message): void
    {
        $note = $this->noteFactory($message);
        // we do not need to mark it as error
        // because it is error as default

        $this->setNote($note);
    }
}
