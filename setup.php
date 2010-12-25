<?php

include dirname(__FILE__) . '/lib/database.php';
include dirname(__FILE__) . '/lib/Order.php';
include dirname(__FILE__) . '/lib/Pizza.php';
include dirname(__FILE__) . '/lib/ProxyPizza.php';
include dirname(__FILE__) . '/lib/PizzaService.php';
include dirname(__FILE__) . '/lib/OrderProxy.php';

$setupok = Database::createTables();

?>

<html>
<head>
<title>
PizzaProxy
</title>
</head>
<body>
<?php if($setupok):?>
  Setup erfolgreich!
<?php else:?>
  Oops! Setup fehlgeschlagen :(
<?php endif;?>
</body>
</html>
