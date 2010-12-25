<?php

if (key_exists("id", $_POST)) {
  
  PizzaService::deleteService($_POST["id"]);
  
}

header("Location: /index.php?action=admin");
exit();