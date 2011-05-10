<?php

$db = new PDO("sqlite:" . dirname(__FILE__) . "/../data/pizza.db");

$pizzerientmp = array();
$pizzentmp = array();

$row = 1;
if (($handle = fopen("preise.csv", "r")) !== FALSE) {
	while (($data = fgetcsv($handle, 4096, ",")) !== FALSE) {
		$num = count($data);
		if($row == 1){
			for ($c=0; $c < $num; $c++) {
				$pizzerientmp[] = $data[$c];
		}
		}else{
			for ($c=0; $c < $num; $c++) {
				$pizzentmp[$row][] = $data[$c];
			}
		}
		$row++;
	}
	fclose($handle);
}

$pizzerien = array();
$pcount = 0; 

for($i=0; $i < count($pizzerientmp); $i++){
	if(!empty($pizzerientmp[$i])){
		$calc = $i % 3;
		if($calc == 0){
			$pizzerien[$pcount]['name'] = $pizzerientmp[$i];
		}else if($calc == 1){
			$pizzerien[$pcount]['telefon'] = $pizzerientmp[$i];
		}else if($calc == 2){
			$pcount++;
		}
	}
}

$db->beginTransaction();

$pizzeriaid = 1;
foreach($pizzerien as $single){
	$query = 'INSERT INTO pizzaservice (id, name, phone) VALUES ('.$pizzeriaid.',"'.$single['name'].'","'.$single['telefon'].'")';
	$db->exec($query);
	$pizzeriaid++;
}

$pizzentmp = array_values($pizzentmp);

for($i=0; $i < count($pizzentmp); $i++){
	if(!empty($pizzentmp[$i])){
		$query = 'INSERT INTO proxypizza (id, name, price) VALUES ('.$pizzentmp[$i][0].',"'.$pizzentmp[$i][1].'","'.$pizzentmp[$i][2].'")';
		unset($pizzentmp[$i][1]); unset($pizzentmp[$i][2]);
		$db->exec($query);
	}
}

for($i=1; $i < $pizzeriaid; $i++){
	for($j=0; $j <= (count($pizzentmp) +1 );$j++){
		if(!empty($pizzentmp[$j])){
			$pizzentmp[$j] = array_values($pizzentmp[$j]);
			$query = 'INSERT INTO pizza (serviceid,proxyid,price,name,menunumber) VALUES ('.$i.','.$pizzentmp[$j][0].','.$pizzentmp[$j][1].',"'.$pizzentmp[$j][2].'",'.$pizzentmp[$j][3].')';
			$db->exec($query); 
			unset($pizzentmp[$j][1]); unset($pizzentmp[$j][2]); unset($pizzentmp[$j][3]);
			}
	}
} 

$db->commit();

?>
