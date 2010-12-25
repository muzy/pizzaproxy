
<?php if (isset($error)):?>
  <?php echo $error?>
<?php else:?>

<form method="post" action="/index.php">
<input type="hidden" name="action" value="savepizza">
<table>
  <tr>
    <th>Service</th>
    <th>Number in Menu</th>
    <th>Name</th>
    <th>Description</th>
    <th>Price (in Cent)</th>
    <th> </th>
  </tr>
  <tr>
    <td>
      <select name="serviceid">
      <?php foreach ($pizzaServices as $service):?>
        <option name="serviceid" value="<?php echo $service['id']?>"><?php echo $service["name"]?></option>
      <?php endforeach;?>
      </select>
    </td>
    <td><input type="text" name="menunumber"></td>
    <td><input type="text" name="name" value=""></td>
    <td><input type="text" name="description" value=""></td>
    <td><input type="text" name="price" value="0"></td>
    <td><input type="submit" value="Save"></td>
  </tr>

</table>
</form>

<?php endif;?>