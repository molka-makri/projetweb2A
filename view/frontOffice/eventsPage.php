<?php

include '../../Controller/eventController.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Serenity Springs</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="author" content="">
  <meta name="keywords" content="">
  <meta name="description" content="">

  <!-- External Stylesheets -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/vendor.css">
  <link rel="stylesheet" type="text/css" href="style.css">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
</head>
<body>
<!-- Header Section -->
<header class="header bg-dark text-white py-3">
    <div class="container">
        <div class="row">
            <!-- Logo Section -->
            <div class="col-md-3">
                <a href="index.php">
                    <img src="images/logo-serenity.png" alt="Serenity Springs Logo" class="img-fluid">
                </a>
            </div>
            
            <!-- Navigation Bar -->
            <div class="col-md-9">
                <nav class="navbar navbar-expand-lg navbar-dark">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                            <li class="nav-item"><a class="nav-link" href="productPage.php">Products</a></li>
                            <li class="nav-item"><a class="nav-link active" href="eventsPage.php">Events</a></li>
                            <li class="nav-item ml-auto"><button type="button" class="btn btn-outline-light">Login Today!</button></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>

<!-- Events Section -->
<section id="events" class="events_section py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12 text-center">
                <h1 class="section-title">Upcoming Events</h1>
                <h2>Join us for our exciting upcoming events!</h2>
            </div>
        </div>

        <!-- PHP Code to Fetch Events from Database -->
        <div class="row" id="events-container">
            <?php
            // Create an instance of the eventController class
            $eventController = new eventsController();
            $events = $eventController->getEvents();

            // Check if there are any events to display
            if ($events && $events->rowCount() > 0) {
                // Loop through each event and output its HTML
                while ($event = $events->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($event['Event_name']) . '</h5>';
                    echo '<p class="card-text">' . htmlspecialchars($event['Event_description']) . '</p>';
                    echo '<p class="card-text"><strong>Date: ' . htmlspecialchars($event['Event_date']) . '</strong></p>';
                    echo '<p class="card-text"><small class="text-muted">Place: ' . htmlspecialchars($event['Event_location']) . '</small></p>';
                    // Participate Button
                    echo '<button class="btn btn-primary participate-btn" data-event-id="' . htmlspecialchars($event['Event_id']) . '" data-event-name="' . htmlspecialchars($event['Event_name']) . '">Participate</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                // Display a message if no events are found
                echo '<div class="col-md-12 text-center">';
                echo '<p>No events available at the moment.</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</section>

<!-- Modal for Participation Form -->
<div class="modal fade" id="participateModal" tabindex="-1" aria-labelledby="participateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="participateModalLabel">Event Participation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="participationForm" method="POST" action="../../view/backOffice/events/participants.php">
                    <div class="mb-3">
                        <label for="username" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Your Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <input type="hidden" name="event_id" id="event_id">
                    <button type="submit" class="btn btn-primary">Validate</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- JavaScript for Modal Behavior -->
<script>
    // Handle button click to show the participation modal
    document.querySelectorAll('.participate-btn').forEach(button => {
        button.addEventListener('click', function() {
            var eventId = this.getAttribute('data-event-id');
            var eventName = this.getAttribute('data-event-name');

            // Set the event ID and name in the modal's form
            document.getElementById('event_id').value = eventId;

            // Open the modal
            new bootstrap.Modal(document.getElementById('participateModal')).show();
        });
    });
</script>



<!-- Footer Section -->
<footer class="footer bg-dark text-white py-3 text-center">
    <div class="container">
        <p>&copy; 2024 Serenity Springs. All rights reserved.</p>
    </div>
</footer>

<!-- JavaScript files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
