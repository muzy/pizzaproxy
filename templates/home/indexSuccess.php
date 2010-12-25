<?php if (count($offers) <= 0):?>
<center>
<div style="font-family: curier; background-color: blue; color: white; width: 320px; height: 320px;">
<pre>
Score: 25                   Lives: ♥♥♥
 
 
           ѫѫѫѫѫѫѫѫ
           
           ѫ ѫ ѫ ѫ ѫ
           
           ѫѫѫѫѫѫѫѫ
          
                .
                .
                .
                .
                ж

Space Invaders
I'll never gonna shoot you
Come along. Where do I belong?
Can you take me home?
</pre>
</div>
</center>
<?php else:?>

<?php if (count($missingPizzas) > 0):?>
<div style="background-color: #f00; color: #fff; padding: 1em;">Fehlende Pizzas:
<?php foreach ($missingPizzas as $missing):?>
  <?php echo $missing["proxy"]?> von <?php echo $missing["service"]?> |
<?php endforeach;?>
</div>
<?php endif;?>

<div class="orderoverview">
  <div class="last">
  <?php if ($lastOrder):?>
    Letzte Bestellung: <?php echo $lastOrder?>
  <?php endif;?>
  </div>
  <div class="next">
  <?php if ($nextOrder):?>
    Nächste Bestellung: <?php echo $nextOrder?>
  <?php endif;?>
  </div>
  <div style="clear: both;"></div>
</div>

<div class="smallcolumn">
<div class="box">
  <h1>Angebote</h1>
  <form action="index.php" method="post" autocomplete="off">
  <input type="hidden" name="action" value="executeorder">
    <table>
      <tr>
        <th width="30px;">Nr.</th>
        <th>Name</th>
        <th width="60px;">Preis</th>
        <th width="105px;">Anzahl</th>
      </tr>
    <?php foreach ($offers as $offer):?>
      <tr>
        <td style="vertical-align: top;"><?php echo $offer["id"]?></td>
        <td>
          <div class="pizza_name">
            <?php echo $offer["name"]?>
          </div>
        </td>
        <td style="vertical-align: top;"><?php echo helper::formatPrice($offer["price"])?></td>
        <td style="vertical-align: top;">
          <input type="text" size="2" name="pizzaids[<?php echo $offer["id"]?>]" id="pid<?php echo $offer["id"]?>" value="0">
          <input type="button" value="+" onClick="increase('pid<?php echo $offer["id"]?>');" style="display: inline; width: 30px;">
          <input type="button" value="-" onClick="decrease('pid<?php echo $offer["id"]?>');" style="display: inline; width: 20px;">
		</td>
      </tr>
    <?php endforeach;?>
    <tr>
      <td colspan="4">
        <input type="submit" name="new" value="Neue Bestellung">
        <input type="submit" name="add" value="hinzufügen zu:">
        <select name="orderid">
          <option>...</option>
          <?php foreach ($groupedOrders as $orderid => $order):?>
            <?php if ($order[0]['status'] == Order::STATUS_WAITING):?>
              <option value="<?php echo $orderid?>"><?php echo $orderid?></option>
            <?php endif;?>
          <?php endforeach;?>
        </select>
      </td>
    </tr>
    </table>
  </form>
</div>
</div>

<div class="smallcolumn">
<div class="box">
  <h1>Offene Bestellungen</h1>
  <table>
    <tr>
      <th colspan="4" style="text-align: left">
      <?php if (count($missingPizzas) > 0):?>
      Keine Bestellung möglich. Jeder PizzaProxy braucht für jeden Service eine reale Pizza.
      <?php else:?>
        Maximal <input type="text" size="2" name="ordercount" id="ordercount" value="20" />
        Artikel aufgeben
        <input type="button" value="Los!" onclick="orderNow();" />
      <?php endif;?>
      </th>
    </tr>
    <tr>
      <th width="60px;">Nr.</th>
      <th>Angebot</th>
      <th width="60px;">Preis</th>
    </tr>
    <?php foreach ($groupedOrders as $orderid => $orders):?>
      <tr>
        <td style="vertical-align: top;"><?php echo $orderid ?></td>
        <td>
          <form action="index.php" method="post" autocomplete="off">
            <input type="hidden" name="action" value="updateorderproxy">
            <ul>
              <?php foreach ($orders as $order) : ?>
                <li><b><input type="text" size="2" name="order[<?php echo $order['orderproxyid']?>]" value="<?php echo $order["amount"] ?>"> X </b>(<?php echo $order["pizzaid"]?>) <?php echo $order["name"]?></li>
              <?php endforeach;?>
            </ul>
            <input type="submit" value="update">
          </form>
        </td>
        <td style="vertical-align: top;">
          <ul class="price">
            <?php foreach ($orders as $i => $order) : ?>
              <li><?php echo helper::formatPrice($order["amount"] * $order["price"])?></li>
            <?php endforeach;?>
          </ul>
          <?php echo helper::formatPrice($groupedPrices[$order['orderid']])?>
        </td>
      </tr>
    <?php endforeach;?>
  </table>
</div>
</div>
<script>
function orderNow() {
  var ordercount = document.getElementById("ordercount").value;
  orderWindow = window.open("/index.php?action=printorder&ordercount="+ordercount, "ordernow", "width=800,height=600,status=yes,scrollbars=yes,resizable=yes");
  orderWindow.focus();
}
function decrease(name) {
  var x = document.getElementById(name);
  if(x.value >= 1){
    x.value--;
  }
}
function increase(name) {
  var x = document.getElementById(name);
  x.value++;
}
</script>
<?php endif;?>
