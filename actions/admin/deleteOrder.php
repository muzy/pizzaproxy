<?php

if (key_exists("id", $_POST)) {
  
  Order::deleteOrder($_POST["id"]);
  
}

header("Location: /index.php?action=order");
exit();