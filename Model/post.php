<?php
class Post {
    private ?int $id;
    private ?string $title;
    private ?string $content;
    private ?string $created_at; 

    public function __construct(?int $id = null, ?string $title = null, ?string $content = null, ?string $created_at = null) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->created_at = $created_at;
    }

    // Getters and Setters
    public function getId(): ?int {
        return $this->id;
    }

    public function getTitle(): ?string {
        return $this->title;
    }

    public function getContent(): ?string {
        return $this->content;
    }

    public function getCreatedAt(): ?string {
        return $this->created_at;
    }

    public function setTitle(?string $title): void {
        $this->title = $title;
    }

    public function setContent(?string $content): void {
        $this->content = $content;
    }

    public function setCreatedAt(?string $created_at): void {
        $this->created_at = $created_at;
    }

    // Helper functions
    public function toArray(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'created_at' => $this->created_at,
        ];
    }

    public static function fromArray(array $data): self {
        return new self(
            $data['id'] ?? null,
            $data['title'] ?? null,
            $data['content'] ?? null,
            $data['created_at'] ?? null
        );
    }
}
?>
