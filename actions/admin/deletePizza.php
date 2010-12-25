<?php

if (key_exists("id", $_POST)) {
  
  Pizza::deletePizza($_POST["id"]);
  
}

header("Location: /index.php?action=admin");
exit();