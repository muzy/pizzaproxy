<?php

ob_start();

$orders = Order::getOrders();

include 'templates/order/indexSuccess.php';

$_content = ob_get_clean();