<?php
include '../../../Controller/eventController.php'; // Include the event controller

// Add an event
if (isset($_POST['event_name'], $_POST['event_description'], $_POST['event_date'], $_POST['event_location'])) {
    if (!empty($_POST['event_name']) && !empty($_POST['event_description']) && !empty($_POST['event_date']) && !empty($_POST['event_location'])) {
        try {
            // Convert event_date to DateTime if required
            $eventDate = new DateTime($_POST['event_date']);

            // Create a new Event object
            $event = new Event(
                null,
                $_POST['event_name'],
                $_POST['event_description'],
                $eventDate,
                $_POST['event_location']
            );

            $eventsController = new eventsController();
            $eventsController->addEvent($event);

            header('Location: event.php?success=1');
            exit;
        } catch (Exception $e) {
            echo "Error while adding event: " . $e->getMessage();
        }
    } else {
        echo "Please fill in all fields.";
    }
}



// Update an event

// Check if the form is submitted to update the event
if (isset($_POST['event_name']) && isset($_POST['event_description']) && isset($_POST['event_date']) && isset($_POST['event_location']) && isset($_POST['event_id'])) {
    // Ensure no fields are empty, but also ensure the event_date is in a valid format
    if (!empty($_POST['event_name']) || !empty($_POST['event_description']) || !empty($_POST['event_date']) || !empty($_POST['event_location'])) {
        
        
        // Create the updated event object
        $updatedEvent = new Event(
            $_POST['event_id'],
            $_POST['event_name'],
            $_POST['event_description'],
            $eventDate,  // Pass the DateTime object
            $_POST['event_location']
        );

        // Create an instance of eventsController
        $eventsController = new eventsController();

        // Update the event in the database
        $eventsController->updateEvent($updatedEvent);

        // Redirect to the events list page after update
        header('Location: events.php');
        exit;
    } else {
        echo "Please fill in at least one field to update.";
    }
}


// Delete an event
if (isset($_POST['delete_event_id'])) {
    $deleteEventId = (int)$_POST['delete_event_id'];

    if ($deleteEventId > 0) {
        try {
            $eventsController = new eventsController();
            $eventsController->deleteEvent($deleteEventId);

            header('Location:event.php');
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid event ID.";
    }
}
?>
<h2 class="mb-4">Add Event</h2>
    <form action="event.php" method="post">
        <div class="mb-3">
            <label for="eventName" class="form-label">Event Name</label>
            <input type="text" class="form-control" id="eventName" name="event_name" required>
        </div>
        <div class="mb-3">
            <label for="eventDescription" class="form-label">Event Description</label>
            <textarea class="form-control" id="eventDescription" name="event_description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="eventDate" class="form-label">Event Date</label>
            <input type="date" class="form-control" id="eventDate" name="event_date" required>
        </div>
        <div class="mb-3">
            <label for="eventlocation" class="form-label">Event location</label>
            <input type="text" class="form-control" id="eventlocaton" name="event_location" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Event</button>
    </form>
</div>

<div class="container mt-5">
    <?php
    // Create an instance of eventController
    $eventsController = new eventsController();

    // Get all events from the database
    $events = $eventsController->getEvents();

    // Check if there are events
    if ($events && $events->rowCount() > 0) {
        echo "<div class='container mt-5'>";
        echo "<h2 class='mb-4'>Event List</h2>";
        echo "<div class='row'>"; // Bootstrap grid starts here

        // Loop through the events and display them as cards
        while ($event = $events->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='col-md-4 mb-4'>";
            echo "<div class='card'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>" . htmlspecialchars($event['Event_name']) . "</h5>";
            echo "<p class='card-text'>" . htmlspecialchars($event['Event_description']) . "</p>";
            echo "<p class='card-text'><strong>Date: " . htmlspecialchars($event['Event_date']) . "</strong></p>";
            echo "<p class='card-text'><small class='text-muted'>Place: " . htmlspecialchars($event['Event_location']) . "</small></p>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }

        echo "</div>"; // Bootstrap grid ends here
        echo "</div>";
    } else {
        echo "<p>No events found.</p>";
    }
    ?>
</div>

<div class="container mt-5">
    <h2>Edit Event</h2>
    <form action="event.php" method="post">
        <!-- Input field for Event ID -->
        <div class="mb-3">
            <label for="eventId" class="form-label">Event ID</label>
            <input type="number" class="form-control" id="eventId" name="event_id" placeholder="Enter Event ID" required>
        </div>

        <!-- Input fields for Event attributes -->
        <div class="mb-3">
            <label for="eventName" class="form-label">Event Name</label>
            <input type="text" class="form-control" id="eventName" name="event_name" placeholder="Enter Event Name">
        </div>
        <div class="mb-3">
            <label for="eventDescription" class="form-label">Event Description</label>
            <textarea class="form-control" id="eventDescription" name="event_description" rows="3" placeholder="Enter Event Description"></textarea>
        </div>
        <div class="mb-3">
            <label for="eventDate" class="form-label">Event Date</label>
            <input type="date" class="form-control" id="eventDate" name="event_date" placeholder="Enter Event Date">
        </div>
        <div class="mb-3">
            <label for="eventlocation" class="form-label">Event location</label>
            <input type="text" class="form-control" id="eventlocation" name="event_location" placeholder="Enter Event Place">
        </div>

        <button type="submit" class="btn btn-primary">Update Event</button>
    </form>
</div>

<div class="container mt-5">
    <h2>Delete Event</h2>
    <form action="event.php" method="post">
        <div class="mb-3">
            <label for="deleteEventId" class="form-label">Event ID</label>
            <input type="number" class="form-control" id="deleteEventId" name="delete_event_id" placeholder="Enter Event ID" required>
        </div>
        
        <button type="submit" class="btn btn-danger">Delete Event</button>
    </form>
</div>
