<?php
include(__DIR__ . '/../Controller/EventController.php');

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Événement</title>
    <!-- Uncomment the line below to add a CSS file for styling -->
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>
<body>

<div class="container">
    <h2>Ajouter un Nouvel Événement</h2>
    
    <!-- Display success or error message -->
    <?php if ($message) : ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <!-- Event addition form -->
    <form action="addevent.php" method="POST">
        <div class="form-group">
            <label for="name">Nom de l'événement :</label>
            <input type="text" id="name" name="name" required>
        </div>
        
        <div class="form-group">
            <label for="date">Date de l'événement :</label>
            <input type="date" id="date" name="date" required>
        </div>

        <div class="form-group">
            <label for="localisation">Localisation :</label>
            <input type="text" id="localisation" name="localisation" required>
        </div>
        
        <div class="form-group">
            <label for="description">Description :</label>
            <textarea id="description" name="description" required></textarea>
        </div>

        <button type="submit">Ajouter l'événement</button>
    </form>
</div>

</body>
</html>
