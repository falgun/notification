<?php
declare(strict_types=1);

namespace Falgun\Notification\Notes;

class SimpleNote implements NoteInterface
{

    public string $message;
    public string $type;

    public function markAsError(): void
    {
        $this->type = 'error';
    }

    public function markAsSuccess(): void
    {
        $this->type = 'success';
    }

    public function markAsWarning(): void
    {
        $this->type = 'warning';
    }
}
