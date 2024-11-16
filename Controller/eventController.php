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
        $sql = "INSERT INTO events (Event_name, Event_description, Event_date, Event_location) VALUES (:Event_name, :Event_description, :Event_date, :Event_location)";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute([
                'Event_name' => $event->getEvent_name(),
                'Event_description' => $event->getEvent_description(),
                'Event_date' => $event->getEvent_date(),
                'Event_location' => $event->getEvent_location()
            ]);
        } catch(Exception $err) {
            echo $err->getMessage();
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
        // Get current event data from the database
        $sql = "SELECT * FROM events WHERE Event_id = :Event_id";
        $db = config::getConnexion();

        try {
            // Fetch the current event data
            $query = $db->prepare($sql);
            $query->execute(['Event_id' => $event->getEvent_id()]);
            $currentEvent = $query->fetch();

            // Prepare the update SQL query
            $sql = "UPDATE events SET 
                    Event_name = COALESCE(:Event_name, :current_Event_name),
                    Event_description = COALESCE(:Event_description, :current_Event_description),
                    Event_date = COALESCE(:Event_date, :current_Event_date),
                    Event_location = COALESCE(:Event_location, :current_Event_location)
                    WHERE Event_id = :Event_id";

            $query = $db->prepare($sql);
            $query->execute([
                'Event_name' => $event->getEvent_name() ?: $currentEvent['Event_name'],
                'Event_description' => $event->getEvent_description() ?: $currentEvent['Event_description'],
                'Event_date' => $event->getEvent_date() ?: $currentEvent['Event_date'],
                'Event_location' => $event->getEvent_location() ?: $currentEvent['Event_location'],
                'Event_id' => $event->getEvent_id(),

                // Use current event values as fallback if not updated
                'current_Event_name' => $currentEvent['Event_name'],
                'current_Event_description' => $currentEvent['Event_description'],
                'current_Event_date' => $currentEvent['Event_date'],
                'current_Event_location' => $currentEvent['Event_location']
            ]);
        } catch (Exception $err) {
            echo $err->getMessage();
        }
    }
}
?>
