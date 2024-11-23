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
    // Fetch an event by ID
    public function getEvent($Event_id) {
        $sql = "SELECT * FROM events WHERE Event_id = :Event_id"; // Use the correct column name
        $db = config::getConnexion();
        $query = $db->prepare($sql);
    
        try {
            $query->execute(['Event_id' => $Event_id]); // Bind the event ID
            return $query->fetch(PDO::FETCH_ASSOC); // Fetch and return the event
        } catch (Exception $e) {
            echo "Error fetching event: " . $e->getMessage();
        }
    }
    
   
    // Update an event
        public function updateEvent($event) {
            $sql = "UPDATE events SET 
                        Event_name = COALESCE(:Event_name, Event_name),
                        Event_description = COALESCE(:Event_description, Event_description),
                        Event_date = COALESCE(:Event_date, Event_date),
                        Event_location = COALESCE(:Event_location, Event_location)
                    WHERE Event_id = :Event_id";
        
            $db = config::getConnexion();
        
            try {
                $query = $db->prepare($sql);
        
                // Format the event date if it is a DateTime object
                $formattedDate = $event->getEvent_date() instanceof DateTime
                                 ? $event->getEvent_date()->format('Y-m-d H:i:s')
                                 : null;
        
                // Execute the update query
                $query->execute([
                    'Event_name' => $event->getEvent_name(),
                    'Event_description' => $event->getEvent_description(),
                    'Event_date' => $formattedDate,
                    'Event_location' => $event->getEvent_location(),
                    'Event_id' => $event->getEvent_id()
                ]);
        
                echo "Event updated successfully!";
            } catch (Exception $e) {
                echo "Error updating event: " . $e->getMessage();
            }
        }
        
    }

?>
