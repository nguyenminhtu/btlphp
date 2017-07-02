<?php 

function swap($a, $b) {
	$t = $$a;
	$$a = $$b;
	$$b = $t;
}

	$a = 5;
	$b = 10;
	
	swap($$a, $$b);

	echo $a . "\n" . $b;

 ?>