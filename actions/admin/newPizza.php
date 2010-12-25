<?php

ob_start();

$pizzaServices = PizzaService::getServices();

if (count($pizzaServices) < 1 ) {
  $error = "Please add service first";
}

include 'templates/admin/newPizzaSuccess.php';

$_content = ob_get_clean();