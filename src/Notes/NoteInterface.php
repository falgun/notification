<?php

namespace Falgun\Notification\Notes;

interface NoteInterface
{

    public function markAsSuccess(): void;

    public function markAsWarning(): void;

    public function markAsError(): void;
}
