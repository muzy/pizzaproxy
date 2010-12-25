<?php
class helper {

  public static function formatPrice($cent) {

    $decimal = $cent%100;

    if ($decimal == 0) $decimal = "00";

    return floor($cent/100) .",$decimal" . " €";
  }

  public static function getMissingPizzas($offers,$pizzaServices,$pizzas) {
    $missingPizzas = array();
    //if I would do 3 wrapped loops at work, my boss would kill me ;)
    foreach ($offers as $proxy) {
      foreach ($pizzaServices as $service) {
        $exists = false;
        foreach ($pizzas as $pizza) {
          if ($pizza["serviceid"] == $service["id"] && $pizza["proxyid"] == $proxy["id"]) {
            $exists = true;
          }
        }
        if ($exists == false) {
          $missingPizzas[] = array("service" => $service["name"], "proxy" => $proxy["name"]);
        }
      }
    }
    return $missingPizzas;
  }

}
