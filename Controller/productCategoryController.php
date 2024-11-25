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

        public function addCategory($category) {
          try {
              $db = config::getConnexion(); // Use the database connection method
              $query = $db->prepare("INSERT INTO products_categories (category) VALUES (:category)");
              $query->bindParam(':category', $category->getCategory(), PDO::PARAM_STR);
              $query->execute();
              return true; // Return success if the query executes successfully
          } catch (PDOException $e) {
              echo $e->getMessage(); // Handle and display the exception
              return false; 
          }
      }
      
      public function modifyCategory($categoryId, $newCategoryName) {
        try {
            // Get the database connection
            $db = config::getConnexion();
    
            // Prepare the update query
            $query = $db->prepare("
                UPDATE products_categories 
                SET category = :category 
                WHERE category_id = :category_id
            ");
    
            // Bind parameters to ensure proper values are used
            $query->bindParam(':category', $newCategoryName, PDO::PARAM_STR);
            $query->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
    
            // Execute the query
            $query->execute();
    
            // Return success if rows were affected
            return $query->rowCount() > 0;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }


        public function deleteCategory($categoryId) {
          try {
              $db = config::getConnexion();
              $query = $db->prepare("DELETE FROM products_categories WHERE category_id = :category_id");
              $query->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
              $query->execute();
          } catch (PDOException $e) {
              echo $e->getMessage();
          }
      }
  



    }


  

?>