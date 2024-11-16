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
    public function getEvent($Event_id) {
        $sql = "SELECT * FROM events WHERE Event_id = :Event_id";
        $db = config::getConnexion();
        $query = $db->prepare($sql);
    
        try {
            $query->execute(['Event_id' => $Event_id]);
            $event = $query->fetch();
            return $event;
        } catch (Exception $e) {
            echo "Error fetching event: " . $e->getMessage();
        }
    }
    

    // Update an event
    public function updateEvent($event) {
        // Fetch the current event data
        $sql = "SELECT * FROM events WHERE Event_id = :Event_id";
        $db = config::getConnexion();
        
        $query = $db->prepare($sql);
        $query->execute(['Event_id' => $event->getEvent_id()]);
        $currentEvent = $query->fetch();
    
        // Prepare the update query
        $sql = "UPDATE events SET 
                Event_name = COALESCE(:Event_name, :current_Event_name),
                Event_description = COALESCE(:Event_description, :current_Event_description),
                Event_date = COALESCE(:Event_date, :current_Event_date),
                Event_location = COALESCE(:Event_location, :current_Event_location)
                WHERE Event_id = :Event_id";
    
        try {
            $query = $db->prepare($sql);
    
            // Convert the DateTime object to string if necessary
            $formattedDate = $event->getEvent_date() instanceof DateTime 
                             ? $event->getEvent_date()->format('Y-m-d') 
                             : $event->getEvent_date();
    
            // Execute the query with new values or fallback to current values if not provided
            $query->execute([
                'Event_name' => $event->getEvent_name() ?: $currentEvent['Event_name'],
                'Event_description' => $event->getEvent_description() ?: $currentEvent['Event_description'],
                'Event_date' => $formattedDate ?: $currentEvent['Event_date'],
                'Event_location' => $event->getEvent_location() ?: $currentEvent['Event_location'],
                'Event_id' => $event->getEvent_id(),
    
                // Use current event values as fallback if not updated
                'current_Event_name' => $currentEvent['Event_name'],
                'current_Event_description' => $currentEvent['Event_description'],
                'current_Event_date' => $currentEvent['Event_date'],
                'current_Event_location' => $currentEvent['Event_location']
            ]);
            
            echo "Event updated successfully!";
        } catch (Exception $err) {
            echo "Error updating event: " . $err->getMessage();
        }
    }
    

}
?>
