<?php

class Events {
    private ?int $id;
    private ?string $NAME;
    private ?DateTime $date;
    private ?string $location;
    private ?string $description;

    // Constructor
    public function __construct(?int $id, ?string $NAME, ?DateTime $date, ?string $location, ?string $description) {
        $this->id = $id;
        $this->NAME = $NAME;
        $this->date = $date;
        $this->location = $location;
        $this->description = $description;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getNAME(): ?string {
        return $this->NAME;
    }

    public function setNAME(?string $NAME): void {
        $this->NAME = $NAME;
    }

    public function getDate(): ?DateTime {
        return $this->date;
    }

    public function setDate(?DateTime $date): void {
        $this->date = $date;
    }

    public function getLocation(): ?string {
        return $this->location;
    }

    public function setLocation(?string $location): void {
        $this->location = $location;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(?string $description): void {
        $this->description = $description;
    }
}

?>
