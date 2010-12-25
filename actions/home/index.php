<?php

ob_start();

$pizzaServices = PizzaService::getServices();
$offers        = ProxyPizza::getPizzas();
$pizzas        = Pizza::getPizzas();
$orders        = Order::getOrders(null,ORDER::STATUS_WAITING,null,"desc");

$lastOrder = Order::getLatestOrder(Order::STATUS_WAITING);
$lastOrder = $lastOrder["id"];
$nextOrder = Order::getNextOrder();

$groupedOrders = array();
$groupedPrices = array();

foreach ($orders as $order) {
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

$missingPizzas = helper::getMissingPizzas($offers,$pizzaServices,$pizzas);

include 'templates/home/indexSuccess.php';

$_content = ob_get_clean();