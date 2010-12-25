<?php
class PizzaService {
  
  CONST TABLE_NAME = "pizzaservice";
  
  public static function getServices($active = null) {
    
    $query = "select * from " . PizzaService::TABLE_NAME;
    
    if ($active === 1) {
      $query .= " where active = 1";
    }
    
    $stmt = Database::pdo()->query($query);
    
    return $stmt->fetchAll();
    
  }
  
  public static function addService($name, $phone, $shipping) {
    
    Database::pdo()->exec("insert into " . PizzaService::TABLE_NAME ." (name, phone, shipping) values ('$name', '$phone', '$shipping')");
    
  }
  
  public static function activateService($id) {
    
    Database::pdo()->exec("update " . PizzaService::TABLE_NAME ." set active = 1 where id = $id");
    
  }
  
  public static function deactivateService($id) {
    
    Database::pdo()->exec("update " . PizzaService::TABLE_NAME ." set active = 0 where id = $id");
    
  }
  
  public static function deleteService($id) {
    
    Database::pdo()->exec("delete from " . Pizza::TABLE_NAME ." where serviceid = $id");
    Database::pdo()->exec("delete from " . PizzaService::TABLE_NAME ." where id = $id");
    
  }
  
}