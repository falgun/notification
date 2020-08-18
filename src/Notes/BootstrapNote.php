<?php
declare(strict_types=1);

namespace Falgun\Notification\Notes;

class BootstrapNote extends SimpleNote implements NoteInterface
{

    public string $icon;

    public function markAsSuccess(): void
    {
        $this->type = 'success';
        $this->icon = 'check';
    }

    public function markAsWarning(): void
    {
        $this->type = 'warning';
        $this->icon = 'exclamation-triangle';
    }

    public function markAsError(): void
    {
        $this->type = 'danger';
        $this->icon = 'times';
    }
}
