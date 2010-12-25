<?php

/* Config */
$config["alternatives_visible"] = 3;
/* Config */

include dirname(__FILE__) . '/lib/database.php';
include dirname(__FILE__) . '/lib/Order.php';
include dirname(__FILE__) . '/lib/OrderProxy.php';
include dirname(__FILE__) . '/lib/Pizza.php';
include dirname(__FILE__) . '/lib/ProxyPizza.php';
include dirname(__FILE__) . '/lib/PizzaService.php';
include dirname(__FILE__) . '/lib/helper.class.php';

$notemplate = false;

header("Content-Type: text/html; charset=utf-8");

if (key_exists("action", $_GET)) {
  
  if ($_GET["action"] == "admin") {
    include 'actions/admin/index.php';
  }
  else if ($_GET["action"] == "newservice") {
    include 'actions/admin/newService.php';
  }
  else if ($_GET["action"] == "newpizza") {
    include 'actions/admin/newPizza.php';
  }
  else if ($_GET["action"] == "order") {
    include 'actions/order/index.php';
  }
  else if ($_GET["action"] == "printorder") {
    include 'actions/order/printOrder.php';
    $notemplate = true;
  }
  
}
else if (key_exists("action", $_POST)) {
  $notemplate = true;
  if ($_POST["action"] == "saveservice") {
    include 'actions/admin/saveService.php';
  }
  else if ($_POST["action"] == "savepizza") {
    include 'actions/admin/savePizza.php';
  }
  else if ($_POST["action"] == "saveproxypizza") {
    include 'actions/admin/saveProxyPizza.php';
  }
  else if ($_POST["action"] == "deleteservice") {
    include 'actions/admin/deleteService.php';
  }
  else if ($_POST["action"] == "deletepizza") {
    include 'actions/admin/deletePizza.php';
  }
  else if ($_POST["action"] == "deleteproxypizza") {
    include 'actions/admin/deleteProxyPizza.php';
  }
  else if ($_POST["action"] == "deleteorder") {
    include 'actions/admin/deleteOrder.php';
  }
  else if ($_POST["action"] == "deleteorderproxy") {
    include 'actions/order/deleteOrderProxy.php';
  }
  else if ($_POST["action"] == "updateorderproxy") {
    include 'actions/home/updateOrderProxy.php';
  }
  else if ($_POST["action"] == "executeorder") {
    include 'actions/order/saveOrder.php';
  }
  else if ($_POST["action"] == "markasordered") {
    include 'actions/order/markAsOrdered.php';
  }
  else if ($_POST["action"] == "setservicestatus") {
    include 'actions/admin/setServiceStatus.php';
  }
  
}
else {
    //home
  include 'actions/home/index.php';
}
//globales template
if (!$notemplate) {
  include 'templates/template.php';
}
?>


