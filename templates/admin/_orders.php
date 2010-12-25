<div class="box">
<h1>Bestellungen</h1>
<table>
    <tr>
      <th>Nr.</th>
      <th>Pizza</th>
      <th>Preis</th>
      <th>Status</th>
      <th></th>
    </tr>
    <?php foreach ($orders as $order):?>
    <tr>
      <td style="vertical-align: top;"><?php echo $order["orderid"]?></td>
      <td>
          (<?php echo $order["pizzaid"]?>) <?php echo $order["name"]?>
      </td>
      <td style="vertical-align: top;"><?php echo round($order["price"]/100,2)?> €</td>
      <td style="vertical-align: top;"><?php echo $order["status"]?></td>
      <td>
      <form method="post" action="index.php" style="display: inline;">
        <input type="hidden" name="id" value="<?php echo $order["orderid"] ?>">
        <input type="hidden" name="action" value="deleteorder">
        <input type="submit" name="delete" value="X" onclick="return confirm('Delete order <?echo $order["orderid"]?>?')">
      </form>
    </td>
    </tr>
    <?php endforeach;?>
</table>
</div>