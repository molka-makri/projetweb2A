<?php
 include_once '../../Controller/userC.php';
 $userC = new userC();
 if(isset($_GET['id'])){
     $userC->deleteUser($_GET['id']);
 
    header('Location:index.php');
    }

 ?>