<?php
class Pizza {
  
  CONST TABLE_NAME = "pizza";
  
  public static function getPizzas() {
    $stmt = Database::pdo()->query("select " . Pizza::TABLE_NAME . ".*,
    	 ". PizzaService::TABLE_NAME .".name as service,
    	 ". ProxyPizza::TABLE_NAME . ".id as proxyid,
    	 ". ProxyPizza::TABLE_NAME . ".name as proxyname from " . Pizza::TABLE_NAME . "
    	  left join ". PizzaService::TABLE_NAME ." 
  		  on " . Pizza::TABLE_NAME . ".serviceid = " . PizzaService::TABLE_NAME . ".id
  		  left join ". ProxyPizza::TABLE_NAME ." 
  		  on " . Pizza::TABLE_NAME . ".proxyid = " . ProxyPizza::TABLE_NAME . ".id");
    
    return $stmt->fetchAll();
    
  }
  
  public static function addPizza($serviceid, $proxyid, $menunumber, $name, $description, $price) {
    
    $stmt = Database::pdo()->exec("insert into " . Pizza::TABLE_NAME ." 
    	(serviceid, proxyid, menunumber, name, description, price) 
    	values ('$serviceid', '$proxyid', '$menunumber', '$name', '$description', '$price')");
    
  }
  
  public static function deletePizza($id) {
    
    //ondelete cascade... sqlite style
    
    //TODO Bei Bedarf sicherhalthalber ein 'restrict' implementieren oder trigger anlegen
    
    Database::pdo()->exec("delete from " . Order::TABLE_NAME ." where pizzaid = $id");
    Database::pdo()->exec("delete from " . Pizza::TABLE_NAME ." where id = $id");
    
  }
  
}