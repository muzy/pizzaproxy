<?php

if (key_exists("name", $_POST) && key_exists("phone", $_POST) && key_exists("shipping", $_POST)) {
  
  PizzaService::addService($_POST["name"], $_POST["phone"], $_POST["shipping"]);
  
}

header("Location: /index.php?action=admin");
exit();