<?php

if (key_exists("pizzaids", $_POST)) {
  
  if (key_exists("new", $_POST)) {
    $neworder = Order::addOrder($_POST["pizzaids"]);
  } else if (key_exists("add", $_POST) && key_exists("orderid", $_POST)) {
    $neworder = Order::addToExcistingOrder($_POST["pizzaids"],$_POST["orderid"]);
  }
}

header("Location: /index.php");
exit();