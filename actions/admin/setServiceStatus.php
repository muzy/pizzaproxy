<?php

if (key_exists("id", $_POST) && key_exists("status", $_POST)) {
  
  if ($_POST["status"] == 1) {
    PizzaService::activateService($_POST["id"]);
  } elseif ($_POST["status"] == 0) {
    PizzaService::deactivateService($_POST["id"]);
  }
  
}

header("Location: /index.php?action=admin");
exit();