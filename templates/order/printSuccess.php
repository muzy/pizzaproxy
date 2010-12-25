<html>
<head>
<title>
PizzaProxy
</title>
<link rel="stylesheet" type="text/css" href="/css/printpreview.css" />
<link rel="stylesheet" type="text/css" href="/css/print.css" media="print"/>  
</head>
<body>
<form style="display: inline;" method="post" action="/index.php" onsubmit="return confirm('Wurde die Liste gedruckt? Nach dem Schließen der Liste ist das nicht mehr möglich!')">
<input type="hidden" name="action" value="markasordered">
<input type="hidden" name="serviceid" value="<?php echo $serviceid ?>">
<?php foreach ($limitedOrders as $order):?>
<input type="hidden" name="orderids[]" value="<?php echo $order["orderid"] ?>">
<?php endforeach;?>
<input class="printbutton" type="submit" value="Als bestellt markieren und Liste schließen">
</form>
<div class="singlecolumn">
<h1>Bestellung bei <?php echo $servicename?>, Tel.: <?php echo $servicephone?></h1>

<table cellspacing="0">
    <tr>
      <th>
        Pizza
        <div class="alternatives">Alternativ Pizza bei Backup-Service</div>
      </th>
      <th width="70">Preis</th>
      <th width="70">Total</th>
      <th>Lieferung erhalten</th>
    </tr>
    <?php foreach ($ordersSummary as $order):?>
      <tr>
        <td>
          <b><?php echo $order["numpizza"]?> x </b>Nr. <?php echo $order["menunumber"]?> "<?php echo $order["name"]?>"
          <div class="alternatives">
            <?php if (key_exists($order["pizzaid"], $ordersAlternatives)):?>
              <?php foreach ($ordersAlternatives[$order["pizzaid"]] as $i => $alternative):?>
                <?php if ($i >= $config["alternatives_visible"]):?>
                  <?php break;?>
                <?php endif;?>
                <span>
                Nr. <?php echo $alternative["menunumber"]?>
                bei
                <?php echo $alternative["servicename"]?> (<?php echo $alternative["phone"]?>)
                <?php if ($i < count($ordersAlternatives[$order["pizzaid"]])-1):?>
                <br />
                <?php endif;?>
                </span>
              <?php endforeach;?>
            <?php endif;?>
          </div>
        </td>
        <td style="vertical-align: top;"><?php echo helper::formatPrice($order["price"])?></td>
        <td style="vertical-align: top;"><?php echo helper::formatPrice($order["numpizza"]*$order["price"])?></td>
        <td width="20" class="check"><div>&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
      </tr>
    <?php endforeach;?>
    <tr class="total">
    <td>Summe</td>
    <td>&nbsp;</td>
    <td><?php echo helper::formatPrice($total)?></td>
    <td>&nbsp;</td>
    </tr>
</table>
</div>

<div class="singlecolumn">
<h1>Bestellungen</h1>
<table cellspacing="0">
    <tr>
      <th>Nr.</th>
      <th>ProxyPizza</th>
      <th>Preis</th>
      <th>Ausgegeben</th>
    </tr>
    <?php foreach ($groupedOrders as $orderid => $orders):?>
    <tr>
      <td style="vertical-align: top;"><?php echo $orderid ?></td>
      <td style="vertical-align: top;">
        <ul>
          <?php foreach ($orders as $order) : ?>
            <li><b><?php echo $order["amount"] ?> X </b>Nr. <?php echo $order["pizzaid"]?> "<?php echo $order["name"]?>"</li>
          <?php endforeach;?>
        </ul>
      </td>
      <td style="vertical-align: top;">
          <ul class="price">
            <?php foreach ($orders as $i => $order) : ?>
              <li><?php echo helper::formatPrice($order["amount"] * $order["price"])?></li>
            <?php endforeach;?>
          </ul>
          <?php echo helper::formatPrice($groupedPrices[$order['orderid']])?>
      </td>
      <td width="20" class="check"><div>&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
    </tr>
    <?php endforeach;?>
</table>
</div>
<script type="text/javascript">
window.print();
</script>
</body>
</html>
