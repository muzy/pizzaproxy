<?php

ob_start();

try { 
  $ordercount = key_exists("ordercount", $_GET)?$_GET["ordercount"]:10;

  $orders = Order::getOrders(null, Order::STATUS_WAITING, $ordercount);
  
  $latestOrder = Order::getLatestOrder(Order::STATUS_ORDERED);
  
  $services = PizzaService::getServices(1);
  
  $firstActiveService = $services[0];
  $lastActiveService  = $services[count($services)-1];

  //round robin
  if ($latestOrder) {
    $serviceid = $latestOrder["serviceid"];
    if ($serviceid >= $lastActiveService["id"]) {
      //new round
      $orderSerivce = $firstActiveService;
    } else {
      $orderSerivceIndex = 0; 
      foreach ($services as $index => $service) {
        if ($service["id"] == $serviceid) {
          $orderSerivceIndex = $index+1;
        }
      }
      $orderSerivce = $services[$orderSerivceIndex];
    }
  } else {
    //first order
    $orderSerivce = $firstActiveService;
  }
  
  $totalAmount = 0;
  
  $limitedOrders = array();
  
  $orderProxyAmountLock = array();
  
  //TODO prüfen, ob limit an einzelbestellungen erreicht muss einbfacher gehen... aber der kopf ist gerade voll quark
  foreach($orders as $order) {
    if (!in_array($order["orderid"], $orderProxyAmountLock)) {
      $orderProxyAmountLock[] = $order["orderid"];
      $orderProxyAmount = OrderProxy::getOrderAmount($order["orderid"]);
      $totalAmount += $orderProxyAmount;
    }
    if ($totalAmount <= $ordercount) {
      $limitedOrders[] = $order;
    }
  }

  $ordersSummary      = Order::getPrintOrders($orderSerivce["id"], $limitedOrders);
  $ordersAlternatives = Order::getPrintOrderAlternatives($orderSerivce["id"], $limitedOrders);
  
  $alternatives = array();
  
  foreach ($services as $service) {
    if ($service['id'] != $orderSerivce["id"]) {
      $alternatives[] = $service;
    }
  }
  

  $total = 0;
  foreach($ordersSummary as $pizzaOrder) {
    $total += $pizzaOrder["numpizza"]*$pizzaOrder["price"];
  }

  if (count($limitedOrders > 0)) {
    $servicename  = $orderSerivce["name"];
    $servicephone = $orderSerivce["phone"];
    $serviceid    = $orderSerivce["id"];
  }
  
  $groupedOrders = array();
  $groupedPrices = array();
  
  foreach ($limitedOrders as $order) {
    $groupedOrders[$order['orderid']][] = $order;
    if (!key_exists($order['orderid'],$groupedPrices))
    {
      $groupedPrices[$order['orderid']] = $order['amount'] * $order['price'];
    }
    else
    {
      $groupedPrices[$order['orderid']] += $order['amount'] * $order['price'];
    }
  }

  include 'templates/order/printSuccess.php';
} catch (Exception $ex) {
  include 'templates/order/printError.php';
}
  echo ob_get_clean();