<?php
include '../../../Controller/eventController.php'; 

// Add an event
if (isset($_POST['event_name'], $_POST['event_description'], $_POST['event_date'], $_POST['event_location'], $_POST['event_organizer'])) {
    if (!empty($_POST['event_name']) && !empty($_POST['event_description']) && !empty($_POST['event_date']) && !empty($_POST['event_location']) && !empty($_POST['event_organizer'])) {
        try {
            // Convert event_date to DateTime if required
            $eventDate = new DateTime($_POST['event_date']);
           
            // Create the event object
            $event = new Event(
                null, // Event ID will be null for adding a new event
                $_POST['event_name'],
                $_POST['event_description'],
                $eventDate, // DateTime object
                $_POST['event_location'],
                null
            );

            // Call the controller to add the event
            $eventsController = new eventsController();
            $eventsController->addEvent($event);

            // Redirect to event page with success
            header('Location: event.php?success=1');
            exit; // Make sure to call exit after header redirection
            
        } catch (Exception $e) {
            echo "Error while adding event: " . $e->getMessage();
        }
    } else {
        echo "Please fill in all fields.";
    }
}

// Update an event
if (isset($_POST['event_name'], $_POST['event_description'], $_POST['event_date'], $_POST['event_location'], $_POST['event_id'], $_POST['event_organizer'])) {
    if (!empty($_POST['event_name']) || !empty($_POST['event_description']) || !empty($_POST['event_date']) || !empty($_POST['event_location']) || !empty($_POST['event_organizer'])) {

        // Ensure event_date is properly initialized as DateTime or null
        $eventDate = !empty($_POST['event_date']) ? new DateTime($_POST['event_date']) : null;

        // Create the updated event object
        $updatedEvent = new Event(
            $_POST['event_id'], // Event ID for updating
            $_POST['event_name'],
            $_POST['event_description'],
            $eventDate, // DateTime object or null
            $_POST['event_location'],
            $_POST['Event_organizer']
        );

        // Call the controller to update the event
        $eventsController = new eventsController();
        $eventsController->updateEvent($updatedEvent);

        // Redirect to event page with success
        header('Location: event.php?success=1');
        exit; // Make sure to call exit after header redirection
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

            // Redirect to event page after deletion
            header('Location: event.php');
            exit;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid event ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Add Event</h2>
    <form id="addEventForm" action="event.php" method="post">
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
            <label for="eventLocation" class="form-label">Event Location</label>
            <input type="text" class="form-control" id="eventLocation" name="event_location" required>
        </div>
        <div class="mb-3">
            <label for="eventOrganizer" class="form-label">Event Organizer</label>
            <input type="number" class="form-control" id="eventOrganizer" name="Event_organizer" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Event</button>
    </form>
</div>

<div class="container mt-5">
    <h2>Event List</h2>
    <?php
    $eventsController = new eventsController();
    $events = $eventsController->getEvents();

    if ($events && $events->rowCount() > 0) {
        echo "<div class='row'>";

        while ($event = $events->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='col-md-4 mb-4'>";
            echo "<div class='card'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>" . htmlspecialchars($event['Event_name']) . "</h5>";
            echo "<p class='card-text'>" . htmlspecialchars($event['Event_description']) . "</p>";
            echo "<p class='card-text'><strong>Date: " . htmlspecialchars($event['Event_date']) . "</strong></p>";
            echo "<p class='card-text'><small class='text-muted'>Place: " . htmlspecialchars($event['Event_location']) . "</small></p>";
            //echo "<p class='card-text'><small class='text-muted'>Organizer: " . htmlspecialchars($event['Event_organizer.Organizer_name']) . "</small></p>";
            echo "<p class='card-text'><small class='text-muted'>ID: " . htmlspecialchars($event['Event_id']) . "</small></p>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }

        echo "</div>";
    } else {
        echo "<p>No events found.</p>";
    }
    ?>
</div>

<!-- Edit Event Form -->
<div class="container mt-5">
    <h2>Edit Event</h2>
    <form action="event.php" method="post">
        <div class="mb-3">
            <label for="eventId" class="form-label">Event ID</label>
            <input type="number" class="form-control" id="eventId" name="event_id" placeholder="Enter Event ID" required>
        </div>
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
            <label for="eventLocation" class="form-label">Event Location</label>
            <input type="text" class="form-control" id="eventLocation" name="event_location" placeholder="Enter Event Place">
        </div>
        <div class="mb-3">
            <label for="eventOrganizer" class="form-label">Event Organizer</label>
            <input type="text" class="form-control" id="eventOrganizer" name="Event_organizer" placeholder="Enter Event Organizer">
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

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="form.js"></script>
</body>
</html>

