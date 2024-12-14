<?php
// Inclure les fichiers nécessaires pour la base de données et les classes

// Include the category controller
require_once "../../controller/userC.php";

$message = '';

if (isset($_POST['entrer'])) {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mdp = $_POST['mot_de_passe'];
    $verification_mdp = $_POST['verification'];
    $role = $_POST['role'];

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
            $user = new User(null, $nom, $email, password_hash($mdp, PASSWORD_DEFAULT),  $role);
            $userC = new UserC();
            $userC->addUser($user);

            

  // Set session variables to display user notification
  session_start();

            $_SESSION['user_added'] = true;
            $_SESSION['user_email'] = $email; // Store the email



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





// Fonction pour afficher le nom du rôle
function getRoleName($role) {
    switch ($role) {
        case '1':
            return 'Administrateur';
        case '2':
            return 'Agriculteur';
        default:
            return 'Utilisateur';
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

    <link href="TheEvent1/img/favicon.ico" rel="icon">
    <link href="TheEvent1/img/favicon.ico" type="img/x-icon" rel="apple-touch-icon">
</head>
<body>




<!-- Chatbot -->
<div id="chatbot">
  <div id="chatbot-header">
    <h4>Assistant Virtuel</h4>
    <button id="close-chatbot">&times;</button>
  </div>
  <div id="chatbot-body">
    <div id="chatbot-messages"></div>
    <input
      type="text"
      id="chatbot-input"
      placeholder="Posez une question..."
    />
    <button id="send-chatbot">Envoyer</button>
  </div>
</div>
<button id="open-chatbot">💬 Aide</button>

<!-- Styles for Chatbot -->
<style>
  #chatbot {
    position: fixed;
    bottom: 0;
    right: 20px;
    width: 300px;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    background-color: #fff;
    display: none;
    flex-direction: column;
  }

  #chatbot-header {
    background-color: #4caf50;
    color: white;
    padding: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
  }

  #chatbot-body {
    display: flex;
    flex-direction: column;
    height: 300px;
  }

  #chatbot-messages {
    flex-grow: 1;
    overflow-y: auto;
    padding: 10px;
    font-size: 14px;
    background-color: #f9f9f9;
  }

  #chatbot-input {
    border: 1px solid #ddd;
    padding: 10px;
    width: calc(100% - 20px);
    margin: 0 10px 10px;
    border-radius: 5px;
  }

  #send-chatbot {
    background-color: #4caf50;
    color: white;
    padding: 10px;
    border: none;
    cursor: pointer;
    width: calc(100% - 20px);
    margin: 0 10px 10px;
    border-radius: 5px;
  }

  #open-chatbot {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #4caf50;
    color: white;
    border: none;
    border-radius: 50%;
    padding: 15px;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

  #send-chatbot:hover,
  #open-chatbot:hover {
    background-color: #45a049;
  }
</style>



















           














<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <a class="navbar-brand" href="#">Serenity Springs</a>
</nav>
<header class="bg-success text-white text-center py-4">
   
<form action="login.php">
<label>
    <input type="submit" value="SE CONNECTER">
</label>
</form>








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
                            </div>
                            <div class="form-group mb-3">
                                <label for="role">Role</label>
                                <input type="role" class="form-control" id="role" name="role" >
                                <span id="roleError" class="text-danger"></span>
                            </div>
                            
                            <button type="submit" class="btn btn-success btn-block" name="entrer">Register</button>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>








<!-- Script for Chatbot -->

  const chatbot = document.getElementById("chatbot");
  const openChatbot = document.getElementById("open-chatbot");
  const closeChatbot = document.getElementById("close-chatbot");
  const sendChatbot = document.getElementById("send-chatbot");
  const chatbotInput = document.getElementById("chatbot-input");
  const chatbotMessages = document.getElementById("chatbot-messages");

  // Show chatbot
  openChatbot.addEventListener("click", () => {
    chatbot.style.display = "flex";
    openChatbot.style.display = "none";
  });

  // Hide chatbot
  closeChatbot.addEventListener("click", () => {
    chatbot.style.display = "none";
    openChatbot.style.display = "block";
  });

  // Handle sending messages
  sendChatbot.addEventListener("click", () => {
    const userMessage = chatbotInput.value.trim();
    if (userMessage) {
      appendMessage("Vous", userMessage);
      chatbotInput.value = "";
      getBotResponse(userMessage);
    }
  });

  // Append a message to the chatbot
  function appendMessage(sender, message) {
    const msgDiv = document.createElement("div");
    msgDiv.innerHTML = `<strong>${sender}:</strong> ${message}`;
    chatbotMessages.appendChild(msgDiv);
    chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
  }

// Generate bot response
function getBotResponse(message) {
    let response = "";
    switch (message.toLowerCase()) {
        case "bonjour":
        case "salut":
            response = "Bonjour ! Comment puis-je vous aider ?";
            break;
        case "quel est objectif principal de ce site ?":
            response = "Ce site est conçu pour vendre vos produits ou acheter des produits avec des prix raisonnables il contient des agriculteurs et tout ce qui touche à lagriculture.";
            break;
        case "comment puis-je inscrire pour utiliser les services du site ?":
            response = "Vous pouvez créer un compte directement sur cette page.";
            break;
        case "le site est-il destiné uniquement aux agriculteurs, ou tout le monde peut y participer ?":
            response = "Tout le monde peut y participer, pas uniquement les agriculteurs.";
            break;
        case "puis-je vendre mes propres produits agricoles sur ce site ?":
            response = "Oui, vous pouvez vendre vos propres produits agricoles sur ce site.";
            break;
        default:
            // Propose une liste de questions disponibles
            response = `
                Désolé, je ne connais pas la réponse à cette question pour l'instant.<br>
                Voici quelques questions que vous pouvez poser :
                <ul>
                    <li><button onclick="setSuggestedQuestion('Quel est objectif principal de ce site ?')">Quel est objectif principal de ce site ?</button></li>
                    <li><button onclick="setSuggestedQuestion('Comment puis-je inscrire pour utiliser les services du site ?')">Comment puis-je inscrire pour utiliser les services du site ?</button></li>
                    <li><button onclick="setSuggestedQuestion('Le site est-il destiné uniquement aux agriculteurs, ou tout le monde peut y participer ?')">Le site est-il destiné uniquement aux agriculteurs, ou tout le monde peut y participer ?</button></li>
                    <li><button onclick="setSuggestedQuestion('Puis-je vendre mes propres produits agricoles sur ce site ?')">Puis-je vendre mes propres produits agricoles sur ce site ?</button></li>
                </ul>
            `;
    }
    appendMessage("Chatbot", response);
}

// Fonction pour insérer la question choisie
function setSuggestedQuestion(question) {
    chatbotInput.value = question;
    sendChatbot.click(); // Simule le clic pour envoyer la question automatiquement
}









    document.getElementById('registerForm').addEventListener('submit', function (e) {
        let isValid = true;

        // Clear previous error messages
        document.getElementById('nameError').textContent = '';
        document.getElementById('emailError').textContent = '';
        document.getElementById('passwordError').textContent = '';
        document.getElementById('confirmPasswordError').textContent = '';
        document.getElementById('roleError').textContent = '';

        // Get form values
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        const confirmPassword = document.getElementById('password_confirmation').value.trim();
        const role = document.getElementById('role').value.trim();
       

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
         // Validation du rôle
         if (role !== '0' && role !== '1' &&  role !== '2' ) {
                document.getElementById('roleError').textContent = 'Rôle invalide.';
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
