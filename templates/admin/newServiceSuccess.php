<form method="post" action="/index.php">
<input type="hidden" name="action" value="saveservice">
<table>
  <tr>
    <th>Pizza Service</th>
    <th>Telefon</th>
    <th style="display: none">Lieferkosten (in Cent)</th>
    <th></th>
  </tr>
  <tr>
    <td><input type="text" name="name"></td>
    <td><input type="text" name="phone"></td>
    <td style="display: none"><input type="text" name="shipping" value="0"></td>
    <td><input type="submit" value="Save"></td>
  </tr>

</table>
</form>