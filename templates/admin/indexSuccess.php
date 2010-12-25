
<?php if (count($missingPizzas) > 0):?>
<div style="background-color: #f00; color: #fff; padding: 1em;">Fehlende Pizzas:
<?php foreach ($missingPizzas as $missing):?>
  <?php echo $missing["proxy"]?> von <?php echo $missing["service"]?> |
<?php endforeach;?>
</div>
<?php endif;?>

<div class="smallcolumn">
<?php include 'templates/admin/_services.php';?>
</div>
<div class="smallcolumn">
<?php include 'templates/admin/_proxyPizzas.php';?>
</div>

<div style="clear: both;"></div>

<div class="column">
<?php include 'templates/admin/_pizzas.php';?>
</div>

<?php //include 'templates/admin/_orders.php';?>
