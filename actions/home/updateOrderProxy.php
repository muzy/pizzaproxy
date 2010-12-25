<?php

if ( key_exists("order", $_POST) && is_array($_POST['order']) ) {
  
  OrderProxy::updateOrders($_POST["order"]);
  
}

header("Location: /index.php");
exit();