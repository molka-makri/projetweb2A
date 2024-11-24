<?php
// Include the controller
include '../../../Controller/eventController.php'; 

// Assume form data is coming from the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['email'];
    $email = $_POST['event_id'];
    $eventId = $_POST['username'];

    // Create an instance of the eventsController
    $controller = new eventsController();

    // Call the addParticipant method
    $controller->addParticipant($email, $eventId,$username);
}
?>
