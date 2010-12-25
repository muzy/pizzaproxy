<?php

if (key_exists("serviceid", $_POST) && key_exists("orderids", $_POST) && is_array($_POST["orderids"])) {
  
  Order::markAsOrdered($_POST["orderids"],$_POST["serviceid"]);
  
} else {
  //TODO more errorhandling goes here...
  die("Error");
}
?>

<html>
<head>
<title>
PizzaProxy
</title>
 
</head>
<body>
<script type="text/javascript">
window.opener.location.reload();
window.close();
</script>
</body>
</html>