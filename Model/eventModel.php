<?php

class Event {
    private ?int $Event_id;
    private ?string $Event_name;
    private ?string $Event_description;
    private ?DateTime $Event_date;
    private ?string $Event_location;
   

    // Constructor
    public function __construct(?int $Event_id, ?string $Event_name, ?string $Event_description,?DateTime $Event_date,?string $Event_location) {
        $this->Event_id = $Event_id;
        $this->Event_name = $Event_name;
        $this->Event_date = $Event_date;
        $this->Event_description = $Event_description;
        $this->Event_location = $Event_location;
        
       
    }

    // Getters and Setters

    public function getEvent_id(): ?int {
        return $this->Event_id;
    }

    public function setEvent_id(?int $Event_id): void {
        $this->Event_id = $Event_id;
    }

    public function getEvent_name(): ?string {
        return $this->Event_name;
    }

    public function setEvent_name(?string $Event_name): void {
        $this->Event_name = $Event_name;
    }

    public function getEvent_description(): ?string {
        return $this->Event_description;
    }

    public function setEvent_description(?string $Event_description): void {
        $this->Event_description = $Event_description;
    }

    public function getEvent_date(): ?DateTime {
        return $this->Event_date;
    }

    public function setEvent_date(?DateTime $Event_date): void {
        $this->Event_date = $Event_date;
    }


    public function getEvent_location(): ?string {
        return $this->Event_location;
    }

    public function setEvent_location(?string $Event_location): void {
        $this->Event_location = $Event_location;
    }

    

   
}

?>
