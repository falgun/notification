<?php
declare(strict_types=1);

namespace Falgun\Notification\Notes;

class SimpleNote implements NoteInterface
{

    public const TYPE_SUCCESS = 'success';
    public const TYPE_WARNING = 'warning';
    public const TYPE_ERROR = 'error';

    protected string $message;
    protected string $type;

    public function __construct(string $message)
    {
        $this->message = $message;
        $this->markAsError();
    }

    /**
     * @psalm-suppress MixedAssignment
     */
    public function markAsError(): void
    {
        $this->type = static::TYPE_ERROR;
    }

    /**
     * @psalm-suppress MixedAssignment
     */
    public function markAsSuccess(): void
    {
        $this->type = static::TYPE_SUCCESS;
    }

    /**
     * @psalm-suppress MixedAssignment
     */
    public function markAsWarning(): void
    {
        $this->type = static::TYPE_WARNING;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }
}
