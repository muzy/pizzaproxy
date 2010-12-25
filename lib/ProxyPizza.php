<?php

class ProxyPizza {
  
  CONST TABLE_NAME = "proxypizza";
  
  public static function getPizzas() {
    $stmt = Database::pdo()->query("select " . ProxyPizza::TABLE_NAME . ".*
    	 from " . ProxyPizza::TABLE_NAME);
    
    return $stmt->fetchAll();
    
  }
  
  public static function addPizza($name, $price) {
    
    $stmt = Database::pdo()->exec("insert into " . ProxyPizza::TABLE_NAME ." 
    	(name, price) 
    	values ('$name', '$price')");
    
  }
  
  public static function delete($id) {
    
    //ondelete cascade... sqlite style
    
    //TODO Bei Bedarf sicherhalthalber ein 'restrict' implementieren oder trigger anlegen
    
    Database::pdo()->exec("delete from " . Order::TABLE_NAME ." where pizzaid = $id");
    Database::pdo()->exec("delete from " . Pizza::TABLE_NAME ." where proxyid = $id");
    Database::pdo()->exec("delete from " . ProxyPizza::TABLE_NAME ." where id = $id");
    
  }
  
}