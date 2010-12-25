<?php

ob_start();

$pizzaServices = PizzaService::getServices();
$pizzas        = Pizza::getPizzas();
$proxypizzas   = ProxyPizza::getPizzas();
$missingPizzas = array();

$missingPizzas = helper::getMissingPizzas($proxypizzas,$pizzaServices,$pizzas);

$orders = Order::getOrders();

include 'templates/admin/indexSuccess.php';

$_content = ob_get_clean();