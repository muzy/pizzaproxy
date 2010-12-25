<?php

if (key_exists("id", $_POST)) {
  
  OrderProxy::delete($_POST["id"]);
  
}

header("Location: /index.php?action=order");
exit();