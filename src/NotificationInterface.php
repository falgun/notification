<?php

namespace Falgun\Notification;

use Notes\NoteInterface;

interface NotificationInterface
{

    public function setNotifications(array $notifications): void;

    public function getNotifications(): array;

    public function hasNotification(): bool;

    public function removeNotifications(): void;

    public function countNotification(): int;

    public function setNote(NoteInterface $note): bool;

    public function flashNotifications(): array;

    public function noteFactory(): NoteInterface;

    public function successNote(string $message): void;

    public function warningNote(string $message): void;

    public function errorNote(string $message): void;
}
