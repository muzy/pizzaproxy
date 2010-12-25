<div class="box">
<h1>ProxyPizzas (Angebote)</h1>
<table>
  <tr>
    <th>Name</th>
    <th>Preis</th>
    <th width="60px;"> </th>
  </tr>
<?php foreach ($proxypizzas as $proxypizza):?>
  <tr>
    <td>
      <div class="pizza_name">
        <?php echo $proxypizza["name"]?>
      </div>
    </td>
    <td><?php echo helper::formatPrice($proxypizza["price"])?></td>
    <td>
      <form method="post" action="index.php" style="display: inline;">
        <input type="hidden" name="id" value="<?php echo $proxypizza["id"] ?>">
        <input type="hidden" name="action" value="deleteproxypizza">
        <input type="submit" name="delete" value="X" onclick="return confirm('Are you sure?')">
      </form>
    </td>
  </tr>
<?php endforeach;?>
<form method="post" action="/index.php">
<input type="hidden" name="action" value="saveproxypizza">
  <tr>
    <td>
      <input type="text" name="name" value=""><br />
    </td>
    <td><input type="text" name="price" value="0" size="3"></td>
    <td><input type="submit" value="Save"></td>
  </tr>
</form>
</table>
</div>