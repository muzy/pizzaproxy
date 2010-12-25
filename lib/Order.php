<?php
class Order {
  
  CONST TABLE_NAME = "pizzaorder";
  
  CONST STATUS_WAITING = "offen";
  
  CONST STATUS_ORDERED = "bestellt";
  
  public static function getOrders($serviceid = null, $status = null, $ordercount = null, $order = "asc") {
    
    $query = "select ". ProxyPizza::TABLE_NAME . ".id as pizzaid,
    	". PizzaService::TABLE_NAME . ".phone as phone,
    	". Pizza::TABLE_NAME . ".menunumber as menunumber,
    	". Pizza::TABLE_NAME . ".price as realprice,
    	". ProxyPizza::TABLE_NAME . ".name as name,
    	". ProxyPizza::TABLE_NAME . ".price as price,
    	". PizzaService::TABLE_NAME . ".name as service,
    	". Order::TABLE_NAME . ".id as orderid,
    	". Order::TABLE_NAME . ".status as status,
    	". OrderProxy::TABLE_NAME . ".amount as amount,
    	". OrderProxy::TABLE_NAME . ".id as orderproxyid
    	from ". Order::TABLE_NAME ." 
    	left join ". OrderProxy::TABLE_NAME ."
    		on ". Order::TABLE_NAME .".id = ". OrderProxy::TABLE_NAME .".orderid 
    	left join ". ProxyPizza::TABLE_NAME . "
    		on  " . OrderProxy::TABLE_NAME . ".proxypizzaid = " . ProxyPizza::TABLE_NAME . ".id
    	left join ". PizzaService::TABLE_NAME . "
    		on  " . Order::TABLE_NAME . ".serviceid = " . PizzaService::TABLE_NAME . ".id
    	left join ". Pizza::TABLE_NAME . "
    		on " . Pizza::TABLE_NAME . ".proxyid = " . ProxyPizza::TABLE_NAME . ".id
    		and ". Order::TABLE_NAME . ".serviceid = " . Pizza::TABLE_NAME . ".serviceid";
    
    if ($status !== null) {
       $query .= " where " . Order::TABLE_NAME . ".status = '$status'";
    }
    
    $query .= " order by ". Order::TABLE_NAME . ".id $order";
    
    if ($ordercount !== null) {
      $query .= " limit $ordercount";
    }

    $stmt = Database::pdo()->query($query);
    $result = $stmt->fetchAll();
    return $result;
    
  }
  
  public static function getPrintOrders($serviceid, array $orders) {
    
    $ordersInStmt = array();
    
    foreach($orders as $order) {
      $ordersInStmt[] = $order["orderid"];
    }
    
    if (count($ordersInStmt) < 1) {
      throw new Exception("Number of Orders must be greater 0");
    }
    //sum (". Pizza::TABLE_NAME . ".price) pizzatotal,
    $query = "select ". OrderProxy::TABLE_NAME . ".proxypizzaid as pizzaid,
    		  ". Pizza::TABLE_NAME . ".name as name,
    		  ". Pizza::TABLE_NAME . ".menunumber as menunumber,
    		  sum (". OrderProxy::TABLE_NAME . ".amount) numpizza,
    		  ". Pizza::TABLE_NAME . ".price as price
    		  from " . Order::TABLE_NAME ."
    		  left join " . OrderProxy::TABLE_NAME ."
    		  	on " . Order::TABLE_NAME .".id = " . OrderProxy::TABLE_NAME .".orderid
    		  left join " . ProxyPizza::TABLE_NAME ."
    		  	on " . OrderProxy::TABLE_NAME .".proxypizzaid = " . ProxyPizza::TABLE_NAME .".id
    		  left join " . Pizza::TABLE_NAME . "
    		    on ". Pizza::TABLE_NAME .".proxyid = " . ProxyPizza::TABLE_NAME .".id
    		  left join " . PizzaService::TABLE_NAME . "
    		    on ". Pizza::TABLE_NAME .".serviceid = " . PizzaService::TABLE_NAME .".id
    		  where ". PizzaService::TABLE_NAME .".id = $serviceid
    		  and ". Order::TABLE_NAME .".status = ".Database::pdo()->quote(ORDER::STATUS_WAITING)."
    		  and ". Order::TABLE_NAME .".id in (". implode(",", $ordersInStmt) .")
    		  group by ". Pizza::TABLE_NAME ."id";

    $stmt = Database::pdo()->query($query);
    $result = $stmt->fetchAll();
    return $result;
    
  }
  
  public static function getPrintOrderAlternatives($serviceid, array $orders) {
    
    $ordersInStmt = array();
    
    foreach($orders as $order) {
      $ordersInStmt[] = $order["orderid"];
    }
    
    if (count($ordersInStmt) < 1) {
      throw new Exception("Number of Orders must be greater 0");
    }

    $query = "select ". OrderProxy::TABLE_NAME . ".proxypizzaid as pizzaid,
    		  ". Pizza::TABLE_NAME . ".name as name,
    		  ". Pizza::TABLE_NAME . ".menunumber as menunumber,
    		  ". PizzaService::TABLE_NAME .".name as servicename,
    		  ". PizzaService::TABLE_NAME .".phone as phone,
    		  sum (". OrderProxy::TABLE_NAME . ".amount) numpizza,
    		  ". Pizza::TABLE_NAME . ".price as price
    		  from " . Order::TABLE_NAME ."
    		  left join " . OrderProxy::TABLE_NAME ."
    		  	on " . Order::TABLE_NAME .".id = " . OrderProxy::TABLE_NAME .".orderid
    		  left join " . ProxyPizza::TABLE_NAME ."
    		  	on " . OrderProxy::TABLE_NAME .".proxypizzaid = " . ProxyPizza::TABLE_NAME .".id
    		  left join " . Pizza::TABLE_NAME . "
    		    on ". Pizza::TABLE_NAME .".proxyid = " . ProxyPizza::TABLE_NAME .".id
    		  left join " . PizzaService::TABLE_NAME . "
    		    on ". Pizza::TABLE_NAME .".serviceid = " . PizzaService::TABLE_NAME .".id
    		  where ". PizzaService::TABLE_NAME .".id != $serviceid
    		  and ". PizzaService::TABLE_NAME .".active = 1
    		  and ". Order::TABLE_NAME .".status = ".Database::pdo()->quote(ORDER::STATUS_WAITING)."
    		  and ". Order::TABLE_NAME .".id in (". implode(",", $ordersInStmt) .")
    		  group by ". Pizza::TABLE_NAME ."id, ". PizzaService::TABLE_NAME .".id";

    $stmt = Database::pdo()->query($query);
    $result = $stmt->fetchAll();
    
    $grpResult = array();
      foreach($result as $row)
      {
        if (!key_exists($row["pizzaid"], $grpResult)) {
          $grpResult[$row["pizzaid"]] = array();
        }
        $grpResult[$row["pizzaid"]][] = $row;
      }
    
    return $grpResult;
    
  }
  
  public static function addOrder(array $pizzaids) {
    
    $totalAmount = 0;
    foreach ($pizzaids as $proxyid => $amount) {
      $totalAmount += $amount;
    }
    
    if ($totalAmount <= 0) {
      return null;
    }
    
    //TODO sqlite+transaction??
    $rows = Database::pdo()->exec("insert into " . Order::TABLE_NAME ." 
      	(status) 
      	values (".Database::pdo()->quote(ORDER::STATUS_WAITING).")");
      
    $orderid = Database::pdo()->lastInsertId();
    foreach ($pizzaids as $proxyid => $amount) {
      
      if (!is_numeric($amount) || $amount <= 0)
      {
        continue;
      }
      
      $rows = Database::pdo()->exec("insert into " . OrderProxy::TABLE_NAME ." 
      	(orderid, proxypizzaid, amount) 
      	values ('$orderid','$proxyid','$amount')");
      
    }
    
    return $rows;    
  }
  
  public static function addToExcistingOrder(array $pizzaids, $orderid) {
    
    foreach ($pizzaids as $proxyid => $amount) {
      
      if (!is_numeric($amount) || $amount <= 0 || !is_numeric($orderid))
      {
        continue;
      }
      
      $stmt = Database::pdo()->query("select * from " . OrderProxy::TABLE_NAME ." where orderid = $orderid and proxypizzaid = $proxyid");
      $orderProxies = $stmt->fetchAll();

      if ($orderProxies != null && count($orderProxies) > 0)
      {
        $rows = Database::pdo()->exec("update " . OrderProxy::TABLE_NAME ." set amount = amount + $amount 
        								where orderid = $orderid and proxypizzaid = $proxyid");
      }
      else
      {
        $rows = Database::pdo()->exec("insert into " . OrderProxy::TABLE_NAME ." 
        	(orderid, proxypizzaid, amount) 
        	values ('$orderid','$proxyid','$amount')");
      }
    }
    
    return $rows;
  }
  
  public static function markAsOrdered(array $orderids, $serviceid) {
    
    $ordersInStmt = array();
    
    foreach($orderids as $orderid) {
      $ordersInStmt[] = $orderid;
    }
    
    if (count($ordersInStmt) < 1) {
      throw new Exception("Number of Orders must be greater 0");
    }
    
    $rows = Database::pdo()->exec("update " . Order::TABLE_NAME ." 
    	set status = ". Database::pdo()->quote(self::STATUS_ORDERED) .",
    	serviceid = $serviceid
    	where id in (". implode(",", $ordersInStmt).")"); 
    
    return $rows;
  }
  
  public static function getLatestOrder($status = null) {
    
    $query = "select * from " . Order::TABLE_NAME;
    
    if ($status != null) {
      $query .= " where status = " . Database::pdo()->quote($status);
    }
    
    $query .= " order by id desc limit 1";
    
    $stmt = Database::pdo()->query($query);
        
    if ($row = $stmt->fetch()) {
      return $row;
    }
    else return null; 
  }
  
  public static function getNextOrder() {
    
    $query = "select * from sqlite_sequence where name = '" . self::TABLE_NAME . "'";
        $stmt = Database::pdo()->query($query);
        
    if ($row = $stmt->fetch()) {
      return $row["seq"] + 1;
    }
    else return null; 
  }
  
  public static function deleteOrder($id) {
    
    $stmt = Database::pdo()->exec("delete from " . OrderProxy::TABLE_NAME ." where orderid = $id");
    $stmt = Database::pdo()->exec("delete from " . self::TABLE_NAME ." where id = $id");
    
  }
  
}