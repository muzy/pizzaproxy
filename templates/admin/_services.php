<div class="box">
<h1>Services</h1>
<table>
  <tr>
    <th>Pizza Service</th>
    <th>Telefon</th>
    <th>Status</th>
    <th style="display: none">Lieferkosten</th>
    <th width="70px;"> </th>
    <th width="30px;"> </th>
  </tr>
<?php foreach ($pizzaServices as $service):?>
  <tr>
    <td><?php echo $service["name"]?></td>
    <td><?php echo $service["phone"]?></td>
    <td>
      <?php if ($service["active"]):?>
      aktiv
      <?php else:?>
      überlastet
      <?php endif;?>
    </td>
    <td style="display: none"><?php echo round($service["shipping"]/100,2)?> €</td>
    <td>
      <form method="post" action="index.php" style="display: inline;">
        <input type="hidden" name="id" value="<?php echo $service["id"] ?>">
        <?php if ($service["active"]):?>
        <input type="hidden" name="action" value="setservicestatus">
        <input type="hidden" name="status" value="0">
        <input type="submit" name="setactive" value="AUS">
        <?php else:?>
        <input type="hidden" name="action" value="setservicestatus">
        <input type="hidden" name="status" value="1">
        <input type="submit" name="setactive" value="AN">
        <?php endif;?>
      </form>
    </td>
    <td>
      <form method="post" action="index.php" style="display: inline;">
        <input type="hidden" name="id" value="<?php echo $service["id"] ?>">
        <input type="hidden" name="action" value="deleteservice">
        <input type="submit" name="delete" value="X" onclick="return confirm('Are you sure?')">
      </form>
    </td>
  </tr>
<?php endforeach;?>
<form method="post" action="/index.php">
<input type="hidden" name="action" value="saveservice">
<tr>
    <td><input type="text" name="name"></td>
    <td><input type="text" name="phone"></td>
    <td style="display: none"><input type="text" name="shipping" value="0"></td>
    <td><input type="submit" value="Save"></td>
  </tr>
</form>
</table>
</div>