<?php
class Database {
  
  private static $instance = null;
  
  /**
   * 
   * @return PDO
   */
  public static function pdo() { 
    if (self::$instance == null) {
      self::$instance = new PDO("sqlite:" . dirname(__FILE__) . "/../data/pizza.db");
    }
    return self::$instance;
  }
  
  public static function createTables() {
    
    $OrderTable = "CREATE TABLE IF NOT EXISTS ". Order::TABLE_NAME ." (id INTEGER PRIMARY KEY AUTOINCREMENT,
     				status VARCHAR(255),
     				serviceid INTEGER)";
    
    $OrderProxyTable = "CREATE TABLE IF NOT EXISTS ". OrderProxy::TABLE_NAME ." (id INTEGER PRIMARY KEY AUTOINCREMENT,
    				orderid INTEGER,
     				proxypizzaid INTEGER,
     				amount INTEGER)";
    
    $PizzaTable = "CREATE TABLE IF NOT EXISTS ". Pizza::TABLE_NAME ."(id INTEGER PRIMARY KEY AUTOINCREMENT,
    									serviceid INTEGER REFERENCES ". PizzaService::TABLE_NAME ."(id) ON DELETE CASCADE,
    									proxyid INTEGER REFERENCES ". ProxyPizza::TABLE_NAME ."(id) ON DELETE CASCADE,
    									menunumber INTEGER,
    									name VARCHAR(255),
    									description TEXT,
    									price INTEGER)";
    $ProxyPizzaTable = "CREATE TABLE IF NOT EXISTS ". ProxyPizza::TABLE_NAME ."(id INTEGER PRIMARY KEY AUTOINCREMENT,
    									name VARCHAR(255),
    									price INTEGER)";
    
    $PizzaServiceTable = "CREATE TABLE IF NOT EXISTS ". PizzaService::TABLE_NAME ."(id INTEGER PRIMARY KEY AUTOINCREMENT,
    									name VARCHAR(255),
    									phone VARCHAR(255),
    									shipping INTEGER,
    									active BOOL DEFAULT 1)";
    
    self::pdo()->beginTransaction();

    $r1 = self::pdo()->exec($OrderTable);
    $r2 = self::pdo()->exec($PizzaTable);
    $r3 = self::pdo()->exec($ProxyPizzaTable);
    $r4 = self::pdo()->exec($PizzaServiceTable);
    $r5 = self::pdo()->exec($OrderProxyTable);

    self::pdo()->commit();

    return $r1 !== false && $r2 !== false && $r3 !== false && $r4 !== false && $r5 !== false;
    
  }
  
}
