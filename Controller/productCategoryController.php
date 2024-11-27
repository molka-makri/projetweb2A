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
       // Get current category data from the database
      $sql = "SELECT * FROM products_categories WHERE category_id = :categoryId";
      $db = config::getConnexion();
      
      // Fetch the current category data
      $query = $db->prepare($sql);
      $query->execute(['categoryId' => $categoryId]);
      $currentProductCategory = $query->fetch();
      // Prepare the update SQL query
      $sql = "UPDATE products_categories SET 
              category = COALESCE(:category, :current_category_name)
              WHERE category_id = :category_id";

      try {
          $query = $db->prepare($sql);
          $query->execute([
              'category' => $newCategoryName ?: $currentProductCategory['category'],
              'category_id' => $categoryId,
              
              // Use current category value as fallback if not updated
              'current_category_name' => $currentProductCategory['category']
          ]);
      } catch (Exception $err) {
          echo $err->getMessage();
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