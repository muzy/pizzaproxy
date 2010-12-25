<?php

if (key_exists("name", $_POST) && key_exists("price", $_POST)) {
  
  ProxyPizza::addPizza($_POST["name"], $_POST["price"]);
  
}

header("Location: /index.php?action=admin");
exit();