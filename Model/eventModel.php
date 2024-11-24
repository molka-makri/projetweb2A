<?php
include(__DIR__ . '/../config.php');

class Event {
    private ?int $Event_id;
    private ?string $Event_name;
    private ?string $Event_description;
    private ?DateTime $Event_date;
    private ?string $Event_location;
    private?int $Event_organizer;  
   

    // Constructor
    public function __construct(?int $Event_id, ?string $Event_name, ?string $Event_description,?DateTime $Event_date,?string $Event_location,?int $Event_organizer) {
        $this->Event_id = $Event_id;
        $this->Event_name = $Event_name;
        $this->Event_date = $Event_date;
        $this->Event_description = $Event_description;
        $this->Event_location = $Event_location;
        $this->Event_organizer = $Event_organizer; 
        
       
    }

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
    public function getEvent_organizer():?int {
        return $this->Event_organizer;
    }
    public function setEvent_organizer(?int $Event_organizer): void {
        $this->Event_organizer = $Event_organizer;
    }
    
}

class Organizer {
    private ?int $Organizer_id;
    private ?string $Organizer_name;
    private ?string $Organizer_email;
   
   

    // Constructor
    public function __construct(?int $Organizer_id, ?string $Organizer_name, ?string $Organizer_email) {
        $this->Organizer_id = $Organizer_id;
        $this->Organizer_name = $Organizer_name;
        $this->Organizer_email = $Organizer_email;
       
    }

    // Getters and Setters

    public function getOrganizer_id(): ?int {
        return $this->Organizer_id;
    }

    public function setOrganizer_id(?int $Organizer_id): void {
        $this->Organizer_id = $Organizer_id;
    }
    public function getOrganizer_name(): ?string {
        return $this->Organizer_name;
    }

    public function setOrganizer_name(?string $Organizer_name): void {
        $this->Organizer_name = $Organizer_name;
    }

    public function getOrganizer_email(): ?string {
        return $this->Organizer_email;
    }

    public function setOrganizer_email(?string $Organizer_email): void {
        $this->Organizer_email = $Organizer_email;
    }

}
   

?>
