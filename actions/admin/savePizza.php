<?php

if (key_exists("serviceid", $_POST) && key_exists("proxyid", $_POST) && key_exists("menunumber", $_POST) && key_exists("name", $_POST)
     && key_exists("description", $_POST)  && key_exists("price", $_POST)) {
  
  Pizza::addPizza($_POST["serviceid"], $_POST["proxyid"], $_POST["menunumber"], $_POST["name"], $_POST["description"], $_POST["price"]);
  
}

header("Location: /index.php?action=admin");
exit();