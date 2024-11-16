<?php
// Include the necessary configuration and model
include('config.php');
include('Model/eventModel.php');
include('Controller/eventController.php');

// Create an instance of the eventsController
$controller = new eventsController();

// Add event logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        // Add new event
        $event = new Event(null, $_POST['Event_name'], $_POST['Event_description'], new DateTime($_POST['Event_date']), $_POST['Event_location']);
        $controller->addEvent($event);
    } elseif (isset($_POST['update'])) {
        // Update existing event
        $event = new Event($_POST['Event_id'], $_POST['Event_name'], $_POST['Event_description'], new DateTime($_POST['Event_date']), $_POST['Event_location']);
        $controller->updateEvent($event);
    }
}

// Delete event logic
if (isset($_GET['delete'])) {
    $eventId = $_GET['delete'];
    // Ensure the event_id is valid before deleting
    if (is_numeric($eventId) && $eventId > 0) {
        $controller->deleteEvent($eventId);
    } else {
        echo "Invalid Event ID!";
    }
}

// Get all events to display
$events = $controller->getEvents();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Management</title>
</head>
<body>

<h2>Event List</h2>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Date</th>
            <th>Location</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($events as $event): ?>
        <tr>
            <td><?php echo $event['Event_id']; ?></td>
            <td><?php echo $event['Event_name']; ?></td>
            <td><?php echo $event['Event_description']; ?></td>
            <td><?php echo $event['Event_date']; ?></td>
            <td><?php echo $event['Event_location']; ?></td>
            <td>
                <a href="event.php?edit=<?php echo $event['Event_id']; ?>">Edit</a> |
                <a href="event.php?delete=<?php echo $event['Event_id']; ?>" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Add Event</h2>
<form method="post">
    <label for="Event_name">Name:</label><br>
    <input type="text" name="Event_name" required><br>
    <label for="Event_description">Description:</label><br>
    <input type="text" name="Event_description" required><br>
    <label for="Event_date">Date:</label><br>
    <input type="date" name="Event_date" required><br>
    <label for="Event_location">Location:</label><br>
    <input type="text" name="Event_location" required><br>
    <button type="submit" name="add">Add Event</button>
</form>

<?php
// Edit Event Logic
if (isset($_GET['edit'])) {
    $eventId = $_GET['edit'];
    $event = $controller->getEventById($eventId);
?>
    <h2>Edit Event</h2>
    <form method="post">
        <input type="hidden" name="Event_id" value="<?php echo $event['Event_id']; ?>">
        <label for="Event_name">Name:</label><br>
        <input type="text" name="Event_name" value="<?php echo $event['Event_name']; ?>" required><br>
        <label for="Event_description">Description:</label><br>
        <input type="text" name="Event_description" value="<?php echo $event['Event_description']; ?>" required><br>
        <label for="Event_date">Date:</label><br>
        <input type="date" name="Event_date" value="<?php echo $event['Event_date']; ?>" required><br>
        <label for="Event_location">Location:</label><br>
        <input type="text" name="Event_location" value="<?php echo $event['Event_location']; ?>" required><br>
        <button type="submit" name="update">Update Event</button>
    </form>
<?php } ?>

</body>
</html>
