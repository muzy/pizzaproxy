<div class="singlecolumn">
<div class="box">
<h1>Bestellungen</h1>
<table>
    <tr>
      <th>Nr.</th>
      <th>Angebot</th>
      <th>Preis</th>
      <th>Pizza</th>
      <th>Preis</th>
      <th>Status</th>
      <th> </th>
    </tr>
    <?php foreach ($orders as $order):?>
    <tr>
      <td style="vertical-align: top;"><?php echo $order["orderid"]?></td>
      <td>
        <b><?php echo $order["amount"]?> X</b>
        <?php echo $order["pizzaid"]?>
        <?php echo $order["name"]?>
      </td>
      <td>
        <?php echo helper::formatPrice($order["price"])?>
      </td>
      <td style="vertical-align: top;">
      <?php if ($order["service"]):?>
        <?php echo $order["menunumber"]?>
        bei
        <?php echo $order["service"]?> (<?php echo $order["phone"]?>)
      <?php endif;?>
      </td>
      <td>
        <?php if ($order["service"]):?>
          <?php echo helper::formatPrice($order["realprice"])?>
        <?php endif; ?>
      </td>
      <td style="vertical-align: top;">
        <?php echo $order["status"]?>
      </td>
      <td>
      <form method="post" action="index.php" style="display: inline;">
        <input type="hidden" name="id" value="<?php echo $order["orderproxyid"] ?>">
        <input type="hidden" name="action" value="deleteorderproxy">
        <input type="submit" name="delete" value="X" onclick="return confirm('Teil-Bestellung löschen?')" title="Teil-Bestelung löschen">
      </form>
      <form method="post" action="index.php" style="display: inline;">
        <input type="hidden" name="id" value="<?php echo $order["orderid"] ?>">
        <input type="hidden" name="action" value="deleteorder">
        <input type="submit" name="delete" value="XX" onclick="return confirm('Gesamte Bestellung (<?echo $order["orderid"]?>) löschen?')" title="Gesamte Bestellung löschen">
      </form>
    </td>
    </tr>
    <?php endforeach;?>
</table>
</div>
</div>