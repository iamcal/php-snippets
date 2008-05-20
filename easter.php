<?php

	function calculate_easter($year){

		$c = floor($year / 100);
		$n = $year - 19 * floor( $year / 19 );
		$k = floor(( $c - 17 ) / 25);
		$i = $c - floor($c / 4) - floor(( $c - $k ) / 3) + 19 * $n + 15;
		$i = $i - 30 * floor( $i / 30 );
		$i = $i - floor( $i / 28 ) * ( 1 - floor( $i / 28 ) * floor( 29 / ( $i + 1 ) ) * floor( ( 21 - $n ) / 11 ) );
		$j = $year + floor($year / 4) + $i + 2 - $c + floor($c / 4);
		$j = $j - 7 * floor( $j / 7 );
		$l = $i - $j;
		$month = 3 + floor(( $l + 40 ) / 44);
		$day = $l + 28 - 31 * floor( $month / 4 );

		return array($month, $day);
	}


	list($month, $day) = calculate_easter(2005);

	echo "easter sunday in 2005 will be on ".date('jS F', mktime(0,0,0,$month,$day,2005));

?>
