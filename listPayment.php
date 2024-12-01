

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Serenity Springs - BackOffice</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="assets/img/kaiadmin/favicon.ico" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
          urls: ["assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />
    <link rel="stylesheet" href="assets/css/demo.css" />

    <style>
      .table {
        width: 100%;
        margin: 20px auto;
        border-collapse: collapse;
      }
      .table th, .table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
      }
      .table th {
        background-color: #4CAF50;
        color: white;
        font-weight: bold;
      }
      .actions a {
        margin: 0 5px;
        color: #007BFF;
        text-decoration: none;
      }
      .actions a:hover {
        text-decoration: underline;
      }
      .main-title {
        text-align: center;
        font-weight: bold;
        font-size: 24px;
        margin: 20px 0;
      }
      .btn-add {
        display: block;
        width: 200px;
        margin: 0 auto 20px;
        text-align: center;
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        border-radius: 5px;
        text-decoration: none;
      }
      .btn-add:hover {
        background-color: #45a049;
      }
    </style>
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="green">
        <div class="sidebar-logo">
          <div class="logo-header" data-background-color="green">
            <a href="index.html" class="logo">
              <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20" />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
              <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
            </div>
            <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
          </div>
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a href="dashboard.php">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-section">
                <h4 class="text-section">commande</h4>
              </li>
              <li class="nav-item">
                <a href="listCommandes.php">
                  <i class="fas fa-layer-group"></i>
                  <p>commande</p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <!-- Navbar -->
      <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">
          <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
            <li class="nav-item topbar-user dropdown hidden-caret">
              <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                <div class="avatar-sm">
                  <img src="assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle" />
                </div>
                <span class="profile-username">Admin</span>
              </a>
              <ul class="dropdown-menu dropdown-user animated fadeIn">
                <li><a class="dropdown-item" href="#">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
      <!-- End Navbar -->
      <?php
// Inclure le fichier PaymentC.php avec un chemin relatif correct
$filePath = '../../Controller/PaymentC.php';  // Revenir deux niveaux pour atteindre le dossier Controller

if (file_exists($filePath)) {
    include_once $filePath;
} else {
    die("Le fichier PaymentC.php est introuvable à l'emplacement : " . $filePath);
}

// Instancier PaymentController et récupérer la liste des paiements
$paymentC = new PaymentController();
$paiements = $paymentC->listPayments();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Paiements</title>
    <!-- Inclure le CSS de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    h1 {
        text-align: center; /* Centrer le titre horizontalement */
    }
    table {
        width: 60%; /* Taille réduite du tableau */
        margin: 0 auto; /* Centrer la table horizontalement */
        border-collapse: collapse; /* Fusionner les bordures pour un style net */
    }
    th, td {
        border: 1px solid #000; /* Ajouter une bordure noire aux cellules */
        padding: 10px; /* Ajouter de l'espace dans les cellules */
        text-align: center; /* Centrer le texte dans les cellules */
    }
    thead th {
        background-color: #00ff00; /* Fond des en-têtes en vert vif */
        color: #000; /* Texte noir pour un contraste clair */
    }
    tbody td {
        background-color: white; /* Fond blanc pour les cellules */
        color: #000; /* Texte noir */
    }
    tbody tr:hover {
        background-color: #f1f1f1; /* Fond gris clair au survol */
    }
</style>


</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Liste des Paiements</h1> <!-- Titre centré -->

        <!-- Table des paiements -->
        <table>
            <thead>
                <tr>
                    <th>ID Paiement</th>
                    <th>ID Commande</th>
                    <th>Date Paiement</th>
                    <th>Montant</th>
                    <th>Moyen de Paiement</th>
                    <th>Numéro Carte</th>
                    <th>statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($paiements as $paiement): ?>
    <tr>
        <td><?= htmlspecialchars($paiement['idPaiement']) ?></td>
        <td><?= htmlspecialchars($paiement['idCommande']) ?></td>
        <td><?= htmlspecialchars($paiement['datePayment']) ?></td>
        <td><?= htmlspecialchars($paiement['montant']) ?></td>
        <td><?= htmlspecialchars($paiement['moyenPaiement']) ?></td>
        <td><?= htmlspecialchars($paiement['numeroCarte']) ?></td>
        <td>
            <?php
            if (isset($paiement['statusPaiement'])) {
                $status = strtolower(trim($paiement['statusPaiement']));
                if ($status === 'en attente') {
                    echo "<span class='badge bg-warning'>En Attente</span>";
                } elseif ($status === 'en cours') {
                    echo "<span class='badge bg-info'>En Cours</span>";
                } else {
                    echo "<span class='badge bg-secondary'>Treminer</span>";
                }
            } else {
                echo "<span class='badge bg-secondary'>Treminer</span>";
            }
            ?>
        </td>
        <td>
            <a href="updatePayment.php?id=<?= $paiement['idPaiement'] ?>" class="btn btn-warning btn-sm">Modifier</a>
            <a href="deletePayment.php?id=<?= $paiement['idPaiement'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce paiement ?');">Supprimer</a>
        </td>
    </tr>
<?php endforeach; ?>

            </tbody>
        </table>

    </div>

    <!-- Inclure le JavaScript de Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



      

    <!-- Core JS Files -->
    <script src="assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="assets/js/plugin/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
