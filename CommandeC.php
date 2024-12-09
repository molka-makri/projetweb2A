<?php
include_once 'models/Payment.php';
// CommandeC.php (le modèle)
class CommandeC {
    public function countNewCommandes() {
        $sql = "SELECT COUNT(*) FROM commandes WHERE statut = 'nouvelle'";  // 'nouvelle' est un exemple de statut
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;
    }

    // Récupérer les commandes de type "fruit" et "légume" depuis la base de données
    public function getStatistiquesCommandes($conn) {
        // Préparer la requête
        $stmt = $conn->prepare("
            SELECT type, 
                   SUM(quantite) AS total_quantite, 
                   SUM(prix) AS total_prix
            FROM commandes
            WHERE type IN ('fruit', 'légume')
            GROUP BY type
            ORDER BY total_quantite DESC
            LIMIT 5
        ");

        // Exécuter la requête
        $stmt->execute();

        // Récupérer les résultats
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


class PaymentController {
    private $paymentModel;

    public function __construct() {
        $this->paymentModel = new Payment();
    }

    // Créer un paiement
    public function createPayment($idCommande, $montant, $datePayment, $moyenPaiement, $numeroCarte, $statusPaiement) {
        $result = $this->paymentModel->createPayment($idCommande, $montant, $datePayment, $moyenPaiement, $numeroCarte, $statusPaiement);
        return $result ? "Paiement ajouté avec succès !" : "Erreur lors de l'ajout du paiement.";
    }

    // Lire tous les paiements d'une commande donnée
    public function getPaymentsByCommande($idCommande) {
        return $this->paymentModel->getPaymentsByCommandeId($idCommande);
    }

    // Lire un paiement par ID
    public function getPayment($idPaiement) {
        return $this->paymentModel->getPaymentById($idPaiement);
    }

    // Mettre à jour un paiement
    public function updatePayment($idPaiement, $montant, $datePayment, $moyenPaiement, $numeroCarte, $statusPaiement) {
        $result = $this->paymentModel->updatePayment($idPaiement, $montant, $datePayment, $moyenPaiement, $numeroCarte, $statusPaiement);
        return $result ? "Paiement mis à jour avec succès !" : "Erreur lors de la mise à jour du paiement.";
    }

    // Supprimer un paiement
    public function deletePayment($idPaiement) {
        $result = $this->paymentModel->deletePayment($idPaiement);
        return $result ? "Paiement supprimé avec succès !" : "Erreur lors de la suppression du paiement.";
    }
}
?>
