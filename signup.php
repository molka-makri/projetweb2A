<?php
// Inclure les fichiers nécessaires pour la base de données et les classes
include 'C:/xampp/htdocs/projetagriculture/config.php';
include 'C:/xampp/htdocs/projetagriculture/Model/user.php';
include 'C:/xampp/htdocs/projetagriculture/Controller/userC.php';

$message = '';

if (isset($_POST['entrer'])) {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mdp = $_POST['mot_de_passe'];
    $verification_mdp = $_POST['verification'];

    try {
        // Vérifier si l'e-mail existe déjà
        $pdo = config::getConnexion();
        $checkIfExists = "SELECT COUNT(*) as count FROM user WHERE email = ?";
        $stmtCheck = $pdo->prepare($checkIfExists);
        $stmtCheck->execute([$email]);
        $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            // Afficher un message si l'email existe
            $message = '<span style="color: red;">Cette adresse mail est déjà associée à un compte existant. Veuillez utiliser une autre adresse.</span>';
        } else {
            // Ajouter l'utilisateur
            $user = new User(null, $nom, $email, password_hash($mdp, PASSWORD_DEFAULT), 0);
            $userC = new UserC();
            $userC->addUser($user);

            // Succès
            echo '<script>
                    alert("Inscription réussie !");
                    window.location.href = "home.html";
                  </script>';
            exit();
        }
    } catch (Exception $e) {
        $message = '<span style="color: red;">Erreur : ' . $e->getMessage() . '</span>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Serenity Springs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <a class="navbar-brand" href="#">Serenity Springs</a>
</nav>
<header class="bg-success text-white text-center py-4">
    <h1>Register</h1>
    <p>Join us and explore our services</p>
</header>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Create an Account</h2>
                        <?php if (!empty($message)) echo $message; ?>
                        <form id="registerForm" method="POST" novalidate autocomplete="off">
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="nom" >
                                <span id="nameError" class="text-danger"></span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" >
                                <span id="emailError" class="text-danger"></span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="mot_de_passe" >
                                <span id="passwordError" class="text-danger"></span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="verification" >
                                <span id="confirmPasswordError" class="text-danger"></span>
                            </div>
                            <button type="submit" class="btn btn-success btn-block" name="entrer">Register</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p>Already have an account? <a href="login.html" class="text-success">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.getElementById('registerForm').addEventListener('submit', function (e) {
        let isValid = true;

        // Clear previous error messages
        document.getElementById('nameError').textContent = '';
        document.getElementById('emailError').textContent = '';
        document.getElementById('passwordError').textContent = '';
        document.getElementById('confirmPasswordError').textContent = '';

        // Get form values
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        const confirmPassword = document.getElementById('password_confirmation').value.trim();

        // Validate name
        if (name === '') {
            document.getElementById('nameError').textContent = 'Name is required.';
            isValid = false;
        }

        // Validate email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === '') {
            document.getElementById('emailError').textContent = 'Email is required.';
            isValid = false;
        } else if (!emailRegex.test(email)) {
            document.getElementById('emailError').textContent = 'Invalid email format.';
            isValid = false;
        }

        // Validate password
        if (password === '') {
            document.getElementById('passwordError').textContent = 'Password is required.';
            isValid = false;
        }

        // Validate confirm password
        if (confirmPassword === '') {
            document.getElementById('confirmPasswordError').textContent = 'Please confirm your password.';
            isValid = false;
        } else if (password !== confirmPassword) {
            document.getElementById('confirmPasswordError').textContent = 'Passwords do not match.';
            isValid = false;
        }

        // Prevent form submission if validation fails
        if (!isValid) {
            e.preventDefault();
        }
    });
</script>
</body>
</html>
