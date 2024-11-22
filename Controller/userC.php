<?php
include_once 'C:/xampp/htdocs/projetagriculture/config.php';
include_once 'C:/xampp/htdocs/projetagriculture/Model/user.php';

class userC
{   
    public function addUser(User $user) {
        try {
            $pdo = config::getConnexion();
            
            // L'e-mail est unique, ajoutez l'utilisateur à la base de données
            $sql = "INSERT INTO user (nom, email, mdp, role) VALUES (?, ?, ?, 0)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user->getNom(), $user->getEmail(), $user->getMdp()]);
            $_SESSION['user_added'] = true;
                    
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    
    
    public function deleteUser($userId) {
        try {
            $sql = "DELETE FROM user WHERE id = :id";
            $stmt = config::getConnexion()->prepare($sql);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            $stmt->execute();
          
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function updateUser($userId, user $user) {
        try {
            $sql = "UPDATE user SET nom = :nom, email = :email, mdp = :mdp, role = :role WHERE id = :id";
            $stmt = config::getConnexion()->prepare($sql);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':nom', $user->getNom(), PDO::PARAM_STR);
            $stmt->bindParam(':email', $user->getEmail(), PDO::PARAM_STR);
            $stmt->bindParam(':mdp', $user->getMdp(), PDO::PARAM_STR);
            $stmt->bindParam(':role', $user->getRole(), PDO::PARAM_INT); // Ajout de la mise à jour du rôle
            $stmt->execute();
            //header('location:display.php');
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
    

    public function listUsers() {
        try {
            $sql = "SELECT * FROM user";
            $stmt = config::getConnexion()->query($sql);
            $users = [];
            if ($stmt) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $user = array(
                        'id' => $row['id'],
                        'nom' => $row['nom'],
                        'email' => $row['email'],
                        'mdp' => $row['mdp'],
                        'role' => $row['role']
                    );
                    $users[] = $user;
                }
            }
            return $users;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
    

    public function listUsersById($userId) {
        try {
            $sql = "SELECT * FROM user WHERE id = :id";
            $stmt = config::getConnexion()->prepare($sql);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            $stmt->execute();
    
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($row) {
                return new User(
                    $row['id'],
                    $row['nom'],
                    $row['email'],
                    $row['mdp'],
                    $row['role']
                );
            } else {
                return null;
            }
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
    
   




   
    
   
    


}

?>


