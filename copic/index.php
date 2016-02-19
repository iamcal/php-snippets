<?php
	$sets = array();

	$lines = file('sets.txt');
	foreach ($lines as $line){
		list($set, $colors) = explode(' ', trim($line), 2);

		if (!strlen(trim($set))) continue;

		$bits = explode('-', $set);
		$set_sub = array_pop($bits);
		$set_pre = implode('-', $bits);

		$colors = explode(', ', $colors);
		foreach ($colors as $color){
			$color = trim($color);
			if (!strlen($color)) continue;
			$all_colors['x'.$color] = 1;
			$sets[$set_pre]['x'.$color][] = $set_sub;
		}
	}


	#
	# output tables
	#

	echo "<table border=1>";

	echo "<tr>";
	echo "<th rowspan=\"2\">Color</th>";
	echo "<th colspan=\"2\">Classic</th>";
	echo "<th colspan=\"2\">Sketch</th>";
	echo "<th colspan=\"4\">Ciao</th>";
	echo "<th>Wide</th>";
	echo "</tr>";

	echo "<tr>";

	echo "<th>72 Pc</th>";
	echo "<th>72 Pc PC</th>";

	echo "<th>72 Pc</th>";
	echo "<th>72 Pc PC</th>";

	echo "<th>72 Pc</th>";
	echo "<th>72 Pc PC</th>";
	echo "<th>36 Pc</th>";
	echo "<th>36 Pc PC</th>";

	echo "<th>12 Pc</th>";
	echo "</tr>";

	ksort($all_colors, SORT_NATURAL);
	foreach (array_keys($all_colors) as $color){
		$lbl = substr($color, 1);

		echo "<tr>";
		echo "<th>{$lbl}</th>";

		show_sets($color, 'Cl-72');
		show_sets($color, 'Cl-72-PC');

		show_sets($color, 'Sk-72');
		show_sets($color, 'Sk-72-PC');

		show_sets($color, 'Ci-72');
		show_sets($color, 'Ci-72-PC');
		show_sets($color, 'Ci-36');
		show_sets($color, 'Ci-36-PC');

		show_sets($color, 'Wi-24');

		echo "</tr>";
	}
	echo "</table>";

	function show_sets($color, $prefix){
		$s = $GLOBALS['sets'][$prefix][$color];
		if (is_array($s) && count($s)){

			$s = implode(' &amp; ', $s);
			echo "<td style=\"width: 35px; text-align: center; background-color: #cfc\">{$s}</td>";
		}else{
			echo "<td>&nbsp;</td>";
		}
	}

	function in_set($color, $set){
		if (in_array('x'.$color, $GLOBALS['sets'][$set])){
			echo "<td style=\"width: 35px\">X</td>";
		}else{
			echo "<td>&nbsp;</td>";
		}
	}

	function num_sets($color, $sets){
		$num = 0;
		foreach ($sets as $set){
			if (in_array('x'.$color, $GLOBALS['sets'][$set])) $num++;
		}

		echo "<td>{$num}</td>";
	}

?>

<style>
body { font-family: arial; }
td { text-align: center; }
</style>
