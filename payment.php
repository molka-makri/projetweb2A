<?php
// Vérifier si l'ID est passé dans l'URL
if (isset($_GET['id'])) {
    $idCommande = $_GET['id'];
} else {
    // Si l'ID n'est pas trouvé, rediriger vers index.php
    header("Location: index.php");
    exit();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once '../../Controller/PaymentC.php'; // Inclure le fichier PaymentC.php

    $paymentC = new PaymentController();

    // Récupérer les données du formulaire
    $paymentData = [
        'idCommande' => $_POST['idCommande'],
        'datePayment' => $_POST['datePayment'],
        'montant' => $_POST['montant'],
        'moyenPaiement' => $_POST['moyenPaiement'],
        'numeroCarte' => $_POST['numeroCarte'] ?? null,
        'statusPaiement' => $_POST['statusPaiement'] // Vérifiez que ces valeurs correspondent à celles de la base de données
    ];

    // Ajouter le paiement à la base de données
    $result = $paymentC->addPayment($paymentData);
    
    if ($result) {
        // Rediriger vers index.php après ajout du paiement
        header("Location: index.php");
        exit();
    } else {
        $error = "Erreur lors de l'ajout du paiement. Veuillez réessayer.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paiement Commande</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Formulaire de Paiement</h2>

        <!-- Afficher un message d'erreur en cas de problème -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Formulaire de paiement -->
        <form action="" method="POST" onsubmit="return validateForm()">
            <div class="mb-3">
                <label for="idCommande" class="form-label">ID de Commande</label>
                <input type="text" class="form-control" id="idCommande" name="idCommande" value="<?= htmlspecialchars($idCommande); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="datePayment" class="form-label">Date de Paiement</label>
                <input type="date" class="form-control" id="datePayment" name="datePayment" required>
            </div>
            <div class="mb-3">
                <label for="montant" class="form-label">Montant</label>
                <input type="number" class="form-control" id="montant" name="montant" min="0.01" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="moyenPaiement" class="form-label">Moyen de Paiement</label>
                <select class="form-control" id="moyenPaiement" name="moyenPaiement" required>
                    <option value="carte_credit">Carte de Crédit</option>
                    <option value="virement">Virement Bancaire</option>
                    <option value="paypal">PayPal</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="numeroCarte" class="form-label">Numéro de Carte (si applicable)</label>
                <input type="text" class="form-control" id="numeroCarte" name="numeroCarte">
            </div>
            <div class="mb-3">
                <label for="statusPaiement" class="form-label">Statut du Paiement</label>
                <select class="form-control" id="statusPaiement" name="statusPaiement" required>
                    <option value="en_attente">En attente</option>
                    <option value="en_cours">En cours</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Confirmer le Paiement</button>
        </form>
    </div>

    <!-- Scripts JavaScript -->
    <script>
        function validateForm() {
            // Vérifier que tous les champs obligatoires sont remplis
            const datePayment = document.getElementById('datePayment').value;
            const montant = document.getElementById('montant').value;
            const moyenPaiement = document.getElementById('moyenPaiement').value;
            const numeroCarte = document.getElementById('numeroCarte').value;

            if (!datePayment || !montant || !moyenPaiement) {
                alert('Tous les champs obligatoires doivent être remplis.');
                return false;
            }

            // Vérifier que le montant est positif
            if (montant <= 0) {
                alert('Le montant doit être un nombre positif.');
                return false;
            }

            // Vérifier si le moyen de paiement est "Carte de Crédit"
            if (moyenPaiement === "carte_credit") {
                // Le numéro de carte doit être non vide et comporter exactement 16 chiffres
                if (!numeroCarte || numeroCarte.length !== 16 || !/^[0-9]{16}$/.test(numeroCarte)) {
                    alert('Le numéro de carte bancaire doit être composé de 16 chiffres.');
                    return false;
                }
            } 
            // Vérifier si le moyen de paiement est "Virement Bancaire"
            else if (moyenPaiement === "virement") {
                // Le numéro de carte doit être rempli pour un virement bancaire
                if (numeroCarte === "") {
                    alert('Le numéro de carte bancaire doit être rempli pour un virement bancaire.');
                    return false;
                }
            }

            return true;
        }

        // Ajouter un gestionnaire d'événements pour détecter la saisie des caractères non numériques dans le champ "numeroCarte"
        document.getElementById('numeroCarte').addEventListener('input', function() {
            let numeroCarteValue = this.value;
            // Supprimer tout caractère non numérique
            this.value = numeroCarteValue.replace(/\D/g, '');

            // Vérifier si des caractères non numériques ont été supprimés et afficher une alerte
            if (numeroCarteValue !== this.value) {
                alert('Le numéro de carte bancaire doit être composé uniquement de chiffres.');
            }

            // Limiter la longueur à 16 caractères
            if (this.value.length > 16) {
                this.value = this.value.slice(0, 16);
            }
        });
    </script>

    <!-- Inclusion du script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
</body>

</html>
