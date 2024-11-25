<?php
include '../../Controller/serviceController.php';

if (isset($_GET['id'])) {
    $controller = new ServiceController();
    $controller->deleteService(htmlspecialchars($_GET['id']));
}

header('Location: servicelist.php');
exit();
?>


