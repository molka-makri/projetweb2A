<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/eventModel.php');

class eventsController {
    // Fetch all events
    public function getEvents() {
        $sql = "SELECT * FROM events";
        $db = config::getConnexion();

        try {
            $list = $db->query($sql);
            return $list;
        } catch(Exception $err) {
            echo $err->getMessage();
        }
    }

  // Add a new event
public function addEvent($event) {
    $sql = "INSERT INTO events (Event_name, Event_description, Event_date, Event_location) 
            VALUES (:Event_name, :Event_description, :Event_date, :Event_location)";
    $db = config::getConnexion();
    
    try {
        $query = $db->prepare($sql);

        // Convert the DateTime object to a string using format 'Y-m-d'
        $formattedDate = $event->getEvent_date() instanceof DateTime 
                         ? $event->getEvent_date()->format('Y-m-d') 
                         : $event->getEvent_date();

        $result = $query->execute([
            'Event_name' => $event->getEvent_name(),
            'Event_description' => $event->getEvent_description(),
            'Event_date' => $formattedDate, // Use formatted date string
            'Event_location' => $event->getEvent_location()
        ]);

        if ($result) {
            echo "Event added successfully!";
        } else {
            echo "Failed to add event.";
        }
        return $result;
    } catch (PDOException $err) {
        echo "Error while adding event: " . $err->getMessage();
        return false;
    }
}

    // Delete an event by ID
    public function deleteEvent($Event_id) {
        $sql = "DELETE FROM events WHERE Event_id = :Event_id";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->bindValue(':Event_id', $Event_id);
            $query->execute();
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    // Fetch a single event by ID
    public function getEventById($Event_id) {
        $sql = "SELECT * FROM events WHERE Event_id = :Event_id";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->bindValue(':Event_id', $Event_id);
            $query->execute();
            $event = $query->fetch();
            return $event;
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    // Update an event
    public function updateEvent($event) {
        $sql = "UPDATE events SET 
                    Event_name = IFNULL(:Event_name, Event_name),
                    Event_description = IFNULL(:Event_description, Event_description),
                    Event_date = IFNULL(:Event_date, Event_date),
                    Event_location = IFNULL(:Event_location, Event_location)
                WHERE Event_id = :Event_id";
        
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'Event_name' => $event->getEvent_name(),
                'Event_description' => $event->getEvent_description(),
                'Event_date' => $event->getEvent_date(),
                'Event_location' => $event->getEvent_location(),
                'Event_id' => $event->getEvent_id()
            ]);
        } catch (Exception $err) {
            echo "Error while updating event: " . $err->getMessage();
        }
    }
    
    }

?>
