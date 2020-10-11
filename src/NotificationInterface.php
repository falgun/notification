<?php

namespace Falgun\Notification;

use Falgun\Notification\Notes\NoteInterface;

interface NotificationInterface
{

    /**
     * @param array<int, NoteInterface> $notifications
     * @return void
     */
    public function setNotifications(array $notifications): void;

    /**
     * @return array<int, NoteInterface>
     */
    public function getNotifications(): array;

    /**
     * @return array<int, NoteInterface>
     */
    public function flashNotifications(): array;

    public function hasNotification(): bool;

    public function removeNotifications(): void;

    public function countNotification(): int;

    public function setNote(NoteInterface $note): bool;

    public function noteFactory(string $message): NoteInterface;

    public function successNote(string $message): void;

    public function warningNote(string $message): void;

    public function errorNote(string $message): void;
}
