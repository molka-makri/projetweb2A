<?php
include 'C:/xampp/htdocs/projetagriculture/Controller/CommandeC.php';

// Créer une instance du contrôleur
$commandeC = new CommandeC();

// Récupérer la liste des commandes
$listeCommandes = $commandeC->listCommandes();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Serenity Springs</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- fevicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <!-- owl stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
</head>

<body class="main-layout">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="#">Serenity Springs</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Nos Commandes</a>
                </li>
               
                </li>
            </ul>
        </div>
    </nav>

    <!-- Slider Section -->
    <section class="slider_section">
        <div id="myCarousel" class="carousel slide banner-main" data-ride="carousel">
            <ul class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class=""></li>
                <li data-target="#myCarousel" data-slide-to="1" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="2" class=""></li>
            </ul>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="first-slide" src="images/banner.jpg" alt="First slide">
                    <div class="container">
                        <div class="carousel-caption relative">
                            <h1>Serenity Springs</h1>
                            <span>FARMING COMPANY</span>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi.</p>
                            <a class="buynow" href="#">Get a quote</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="second-slide" src="images/banner.jpg" alt="Second slide">
                    <div class="container">
                        <div class="carousel-caption relative">
                            <h1>Our Services</h1>
                            <span>Farming Excellence</span>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            <a class="buynow" href="#">Get a quote</a>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                <i class='fa fa-angle-left'></i>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <i class='fa fa-angle-right'></i>
            </a>
        </div>
    </section>

    <!-- Commandes Section -->
    <section id="commandes" class="container my-5">
    <h2 class="text-center mb-4">les Commandes disponibles</h2>
  
    <!-- Displaying Orders in Cards -->
    <div class="row">
        <?php foreach ($listeCommandes as $commande): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm rounded-lg">
                    <div class="card-header d-flex align-items-center">
                        <!-- Image de commande -->
                        <img src="<?= 'images/offer2.png' ?>" alt="Offer Image" class="img-fluid rounded-circle" style="width: 50px; height: 50px; margin-right: 15px;">
                        <h4 class="mb-0">Commande <?= $commande['idCommande']; ?></h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Produit :</strong> <?= $commande['type']; ?></p>
                        <p><strong>Quantité :</strong> <?= $commande['quantite']; ?></p>
                        <p><strong>Prix unitaire :</strong> <?= number_format($commande['prix'], 2); ?> €</p>
                        <p><strong>Date de commande :</strong> <?= $commande['dateCommande']; ?></p>
                        <p><strong>Total :</strong> <?= number_format($commande['quantite'] * $commande['prix'], 2); ?> €</p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="paymentPage.php?id=<?= $commande['idCommande']; ?>" class="btn btn-primary btn-block">Passer au paiement</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<style>
    .card {
    border: 1px solid #ddd; /* Bordure subtile */
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    background-color: #fff;
}

.card:hover {
    transform: translateY(-5px); /* Effet de survol */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Ombre plus marquée */
}

.card-header {
    background-color: #f8f9fa; /* Couleur de fond de l'entête */
    font-weight: bold;
    font-size: 1.2rem;
}

.card-body {
    padding: 20px;
}

.card-footer {
    background-color: #f8f9fa;
    border-top: 1px solid #ddd;
}

.card-footer .btn {
    font-size: 1rem;
    padding: 12px;
    border-radius: 25px;
    background-color: #007bff;
    color: white;
    border: none;
    transition: background-color 0.3s ease;
}

.card-footer .btn:hover {
    background-color: #0056b3;
}

h4 {
    font-size: 1.3rem;
    margin-bottom: 0;
}

/* Ajout d'un espacement à l'image pour un meilleur alignement */
.card-header img {
    margin-right: 15px;
}

.card-body p {
    margin-bottom: 10px;
    font-size: 1rem;
    line-height: 1.5;
}

.card-footer .btn-block {
    width: 100%;
}
</style>


    <!-- Footer -->
    <footer>
        <div class="footer top_layer ">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                        <div class="address">
                            <a href="index.html"> <img src="images/logo.png" alt="logo" /></a>
                            <p>dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                        <div class="address">
                            <h3>Quick links</h3>
                            <ul class="Links_footer">
                                <li><img src="icon/3.png" alt="#" /> <a href="#"> Join Us</a> </li>
                                <li><img src="icon/3.png" alt="#" /> <a href="#">Maintenance</a> </li>
                                <li><img src="icon/3.png" alt="#" /> <a href="#">Language Packs</a> </li>
                                <li><img src="icon/3.png" alt="#" /> <a href="#">LearnPress</a> </li>
                                <li><img src="icon/3.png" alt="#" /> <a href="#">Release Status</a> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                        <div class="address">
                            <h3>Subcribe email</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </p>
                            <input class="form-control" placeholder="Your Email" type="type" name="Your Email">
                            <button class="submit-btn">Submit</button>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                        <div class="address">
                            <h3>Contact Us</h3>
                            <ul class="loca">
                                <li>
                                    <a href="#"><img src="icon/loc.png" alt="#" /></a>London 145<br>United Kingdom
                                </li>
                                <li>
                                    <a href="#"><img src="icon/email.png" alt="#" /></a>demo@gmail.com
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JS Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>
