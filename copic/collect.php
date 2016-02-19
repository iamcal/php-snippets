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

		$colors = explode(', ', $colors);
		foreach ($colors as $color){
			$color = trim($color);
			if (!strlen($color)) continue;
			$all_colors['x'.$color] = 1;
			$sets[$set]['x'.$color] = 1;
		}
	}


	#
	# see what happens in the sets we want
	#

	$collect = array(
		'Cl-72-A',
		'Cl-72-B',
		'Cl-72-C',
		'Sk-72-D',
		'Sk-72-E',
	);

	$nums = array();

	foreach ($all_colors as $col => $junk){
		$num = 0;
		foreach ($collect as $set){
			if ($sets[$set][$col]) $num++;
		}
		$nums[$num]++;
	}

	print_r($nums);

