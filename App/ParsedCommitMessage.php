<?php
namespace App;

class ParsedCommitMessage implements CommitMessage
{
    private string $title;
    private ?int $taskId;
    private array $tags;
    private array $details;
    private array $bcBreaks;
    private array $todos;

    public function __construct(
        string $title,
        ?int $taskId,
        array $tags,
        array $details,
        array $bcBreaks,
        array $todos
    ) {
        $this->title = $title;
        $this->taskId = $taskId;
        $this->tags = $tags;
        $this->details = $details;
        $this->bcBreaks = $bcBreaks;
        $this->todos = $todos;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getTaskId(): ?int {
        return $this->taskId;
    }

    public function getTags(): array {
        return $this->tags;
    }

    public function getDetails(): array {
        return $this->details;
    }

    public function getBCBreaks(): array {
        return $this->bcBreaks;
    }

    public function getTodos(): array {
        return $this->todos;
    }
}
