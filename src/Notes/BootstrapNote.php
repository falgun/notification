<?php
declare(strict_types=1);

namespace Falgun\Notification\Notes;

class BootstrapNote extends SimpleNote implements NoteInterface
{

    public const TYPE_SUCCESS = 'success';
    public const TYPE_WARNING = 'warning';
    public const TYPE_ERROR = 'danger';

    protected string $icon;

    public function markAsSuccess(): void
    {
        parent::markAsSuccess();
        $this->icon = 'check';
    }

    public function markAsWarning(): void
    {
        parent::markAsWarning();
        $this->icon = 'exclamation-triangle';
    }

    public function markAsError(): void
    {
        parent::markAsError();
        $this->icon = 'times';
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): void
    {
        $this->icon = $icon;
    }
}
