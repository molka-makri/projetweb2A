<?php

class ProductCategory {

  private ?int $category_id;
  private ?string $category;


public function __construct(?int $category_id , ?string $category){
  $this->category_id = $category_id;
  $this->category = $category;
}


  // getters and setters ;


  public function getCategoryId (): ?int {
    return $this->category_id;
  }


  public function setCategoryId (?int $id) : void {
    $this->category_id = $id;

  }


  public function getCategory(): ?string {
    return $this->category;
  }

  public function setCategory(?string $category): void {
    $this->category = $category;
  }


}


?>