<?php

include_once(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/productCategoryModel.php');

    class productCategoryController {

        public function getCategories(){
            try {
              $db = config::getConnexion();
              $query = $db->prepare("SELECT * from products_categories");
              $query->execute();
              return $query->fetchAll();
            }
            catch(PDOExeption $e){
              echo $e->getMessage();
            }
        }

        public function getProductsFromCategory($idCategory){
          try {
            $db = config::getConnexion();
            $query = $db->prepare("SELECT * from products where Product_categorie = :idCategory");
            $query->execute(['idCategory' => $idCategory]);
            return $query->fetchAll();
          }
          catch(PDOExeption $e){
            echo $e->getMessage();
          }


        }
    }




?>