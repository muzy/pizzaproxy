<div class="box">
<h1>Pizzas</h1>
<table>
  <tr>
    <th>Pizza Service</th>
    <th>Proxy-Pizza</th>
    <th>Menü-Nr.</th>
    <th>Name</th>
    <th>Preis</th>
    <th width="60px;"> </th>
  </tr>
<?php foreach ($pizzas as $pizza):?>
  <tr>
    <td><?php echo $pizza["service"]?></td>
    <td><?php echo $pizza["proxyname"]?></td>
    <td><?php echo $pizza["menunumber"]?></td>
    <td>
    <div class="pizza_name">
        <?php echo $pizza["name"]?>
      </div>
      <div  class="pizza_description" style="display:none;">
        <?php echo $pizza["description"]?>
      </div>
    </td>
    <td><?php echo helper::formatPrice($pizza["price"])?></td>
    <td>
      <form method="post" action="index.php" style="display: inline;">
        <input type="hidden" name="id" value="<?php echo $pizza["id"] ?>">
        <input type="hidden" name="action" value="deletepizza">
        <input type="submit" name="delete" value="X" onclick="return confirm('Are you sure?')">
      </form>
    </td>
  </tr>
<?php endforeach;?>
<form method="post" action="/index.php">
<input type="hidden" name="action" value="savepizza">
  <tr>
    <td>
      <select name="serviceid">
      <?php foreach ($pizzaServices as $service):?>
        <option name="serviceid" value="<?php echo $service['id']?>"><?php echo $service["name"]?></option>
      <?php endforeach;?>
      </select>
    </td>
    <td>
      <select name="proxyid">
      <?php foreach ($proxypizzas as $proxy):?>
        <option name="serviceid" value="<?php echo $proxy['id']?>"><?php echo $proxy["name"]?></option>
      <?php endforeach;?>
      </select>
    </td>
    <td><input type="text" name="menunumber" size="3"></td>
    <td>
      <input type="text" name="name" value=""><br />
      <textarea type="text" name="description" value=""  style="display:none;">
      </textarea>
    </td>
    <td><input type="text" name="price" value="0" size="3"></td>
    <td><input type="submit" value="Save"></td>
  </tr>
</form>
</table>
</div>
