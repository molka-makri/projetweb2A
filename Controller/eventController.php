<?php
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


public function addEvent($event) {
    $sql = "INSERT INTO events (Event_name, Event_description, Event_date, Event_location,Event_organizer) 
            VALUES (:Event_name, :Event_description, :Event_date, :Event_location,:Event_organizer)";
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
            'Event_location' => $event->getEvent_location(),
            'Event_organizer' => $event->getEvent_organizer() 
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
                        Event_location = COALESCE(:Event_location, Event_location),
                        Event_organizer = COALESCE(:Event_organizer, Event_organizer)
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
                    'Event_id' => $event->getEvent_id(),
                    'Event_organizer' => $event->getEvent_organizer() // Add the event organizer as an additional field in your table. If not present in your model, add it here.
                ]);
        
                echo "Event updated successfully!";
            } catch (Exception $e) {
                echo "Error updating event: " . $e->getMessage();
            }
        }

        public function getEventsByOrganizer($organizerId) {
            $db = new PDO('mysql:host=localhost;dbname=serenity_springs', 'root', ''); // Adjust credentials
            $sql = "SELECT * FROM events WHERE Event_organizer = :Organizer_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':Organizer_id', $organizerId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        }
        

        public function addParticipant($username, $email, $eventId) {
            $db = config::getConnexion();
        
            try {
                // Disable foreign key checks
                $db->exec("SET foreign_key_checks = 0");
        
                // Check if the participant already exists for this event
                $checkSql = "SELECT * FROM event_participations WHERE email = :email AND event_id = :event_id";
                $checkQuery = $db->prepare($checkSql);
                $checkQuery->execute(['email' => $email, 'event_id' => $eventId]);
        
                if ($checkQuery->rowCount() > 0) {
                    echo "You are already registered for this event.";
                    return;
                }
        
                // Create a new Participant object and save it
                $participant = new Participant($username, $email, $eventId, $db);
        
                if ($participant->save()) {
                    // Send confirmation email to the participant
                    $subject = "Thank You for Participating in the Event";
                    $message = "Hello $username,\n\nThank you for participating in the event. We will send you more details soon.";
                    $headers = "From: no-reply@serenitysprings.com";
                    //mail($email, $subject, $message, $headers);
        
                    echo "<div style='font-size: 24px; font-weight: bold; color: green; text-align: center;'>Thank you for your participation! A confirmation email has been sent.</div>";

                } else {
                    echo "There was an error processing your participation. Please try again.";
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            } finally {
                // Re-enable foreign key checks
                $db->exec("SET foreign_key_checks = 1");
            }
        }
        
        
        
        

    }
        
   
     
    

    

class organizersController {
    // Fetch all organizers
    public function getorganizers() {
        $sql = "SELECT * FROM organizers";
        $db = config::getConnexion();

        try {
            $list = $db->query($sql);
            return $list;
        } catch (Exception $err) {
            echo $err->getMessage();
        }
    }

    // Add a new organizer
    public function addorganizers($organizer) {
        $sql = "INSERT INTO organizers (Organizer_name, Organizer_email) 
                VALUES (:Organizer_name, :Organizer_email)";
        $db = config::getConnexion();
    
        try {
            $query = $db->prepare($sql);
            $result = $query->execute([
                'Organizer_name' => $organizer->getOrganizer_name(),
                'Organizer_email' => $organizer->getOrganizer_email()
            ]);
    
            if ($result) {
                echo "organizer added successfully!";
            } else {
                echo "Failed to add organizer.";
            }
        } catch (PDOException $err) {
            echo "Error while adding organizer: " . $err->getMessage();
            return false;
        }
    }
    public function deleteorganizer($Organizer_id) {
        $sql = "DELETE FROM organizers WHERE Organizer_id = :Organizer_id";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->bindValue(':Organizer_id', $Organizer_id, PDO::PARAM_INT);
            $query->execute();
            echo "Organizer deleted successfully!";
        } catch (Exception $e) {
            echo "Error deleting organizer: " . $e->getMessage();
        }
    }

    // Fetch a single organizer by ID
    public function getorganizer($Organizer_id) {
        $sql = "SELECT * FROM organizers WHERE Organizer_id = :Organizer_id";
        $db = config::getConnexion();
        $query = $db->prepare($sql);

        try {
            $query->execute(['Organizer_id' => $Organizer_id]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error fetching organizer: " . $e->getMessage();
        }
    }

    // Update an organizer
   /* public function updatorganizer($organizer) {
        $sql = "UPDATE organizers SET 
                    Organizer_name = COALESCE(:Organizer_name, Organizer_name),
                    Organizer_email = COALESCE(:Organizer_email, Organizer_email)
                WHERE Organizer_id = :Organizer_id";
    
        $db = config::getConnexion();
    
        try {
            $query = $db->prepare($sql);
            $result = $query->execute([
                'Organizer_name' => $organizer->getOrganizer_name(),
                'Organizer_email' => $organizer->getOrganizer_email(),
                'Organizer_id' => $organizer->getOrganizer_id()
            ]);
    
            if ($result) {
                return "Organizer updated successfully!";
            } else {
                return "No changes made to the organizer.";
            }
        } catch (Exception $e) {
            error_log("Error updating organizer: " . $e->getMessage());
            return "Error updating organizer.";
        }
    }*/
    public function updateAndReplaceOrganizer($organizer) {
        $db = config::getConnexion();
    
        try {
            // 1. Delete the previous organizer from the database
            $deleteSql = "DELETE FROM organizers WHERE Organizer_id = :Organizer_id";
            $deleteQuery = $db->prepare($deleteSql);
            $deleteQuery->execute(['Organizer_id' => $organizer->getOrganizer_id()]);
    
            // 2. Insert the new organizer
            $insertSql = "INSERT INTO organizers (Organizer_id, Organizer_name, Organizer_email)
                          VALUES (:Organizer_id, :Organizer_name, :Organizer_email)";
            $insertQuery = $db->prepare($insertSql);
            $insertQuery->execute([
                'Organizer_id' => $organizer->getOrganizer_id(),
                'Organizer_name' => $organizer->getOrganizer_name(),
                'Organizer_email' => $organizer->getOrganizer_email()
            ]);
    
            // If both queries were successful, redirect or return a success message
            header('Location: organizer.php?success=1');
            exit; // Ensure no code runs after the redirection
    
        } catch (Exception $e) {
            // Handle errors (e.g., if any query fails)
            echo "Error: " . $e->getMessage();
        }
    }
    
    
    

    // Fetch events by organizer ID
    public function afficheEventsByOrganizer($Organizer_id) {
        $sql = "SELECT * FROM organizers WHERE Organizer_id = :Organizer_id";
        $db = config::getConnexion();
        $query = $db->prepare($sql);

        try {
            
            $query->execute(['Organizer_id' => $Organizer_id]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching events by organizer: " . $e->getMessage();
        }
    }

    // Fetch all organizers
    public function afficheOrganizers() {
        $sql = "SELECT * FROM organizers";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching organizers: " . $e->getMessage();
        }
    }
}
?>
