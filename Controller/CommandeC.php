<?php

require 'C:/xampp/htdocs/projetagriculture/config.php';

class CommandeC
{
    public function listCommandes()
    {
        $sql = "SELECT * FROM commande";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function deleteCommande($idCommande)
    {
        $sql = "DELETE FROM commande WHERE idCommande = :idCommande";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':idCommande', $idCommande);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function addCommande($commande)
    {
        $sql = "INSERT INTO commande (idCommande, type, prix, dateCommande, quantite)  
        VALUES (NULL, :type, :prix, :dateCommande, :quantite)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'type' => $commande->getType(),
                'prix' => $commande->getPrix(),
                'dateCommande' => $commande->getDateCommande(),
                'quantite' => $commande->getQuantite()
            ]);
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }
    function showCommande($idCommande)
{
    $sql = "SELECT * FROM commande WHERE idCommande = :idCommande";  // Use parameterized query
    $db = config::getConnexion();

    try {
        // Prepare and execute the SQL query with the bound idCommande parameter
        $query = $db->prepare($sql);
        $query->bindValue(':idCommande', $idCommande, PDO::PARAM_INT);
        $query->execute();

        // Fetch the result as an associative array
        $commande = $query->fetch(PDO::FETCH_ASSOC);
        
        // Return the retrieved commande
        return $commande;
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}
// In your CommandeController.php (CommandeC.php)
function updateCommande($commande, $idCommande)
{   
    try {
        $db = config::getConnexion();
        
        // Prepare the SQL update query
        $query = $db->prepare(
            'UPDATE commande SET 
                type = :type, 
                prix = :prix, 
                dateCommande = :dateCommande, 
                quantite = :quantite
            WHERE idCommande = :idCommande'
        );

        // Execute the query with the values from the $commande object
        $query->execute([
            'idCommande' => $idCommande,
            'type' => $commande->getType(),
            'prix' => $commande->getPrix(),
            'dateCommande' => $commande->getDateCommande(),
            'quantite' => $commande->getQuantite(),
        ]);

        // Optionally echo how many rows were updated (if useful)
        echo $query->rowCount() . " record(s) UPDATED successfully <br>";

    } catch (PDOException $e) {
        die('Error: ' . $e->getMessage());
    }
}

}
