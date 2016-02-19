<?php
	
	#
	# load set data
	#

	$sets = array();
	$all_colors = array();

	$lines = file('sets.txt');
	foreach ($lines as $line){
		list($set, $colors) = explode(' ', trim($line), 2);

		if (!strlen(trim($set))) continue;
		if (strpos($set, 'Cl-') !== 0) continue;

		$colors = explode(', ', $colors);
		foreach ($colors as $color){
			$color = trim($color);
			if (!strlen($color)) continue;
			$all_colors['x'.$color] = 1;
			$sets[$set]['x'.$color] = 1;
		}
	}


	#
	# build prefix list
	#

	$groups = array();
	foreach ($all_colors as $k => $v){
		if (preg_match('!^x([a-z]+)!i', $k, $m)){
			$groups[$m[1]]++;
		}
	}

	print_r($groups);
