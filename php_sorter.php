<?
	#get rows
	$rows6 = array();
	while($row6 = mysql_fetch_array($result6)){
		$rows6[] = $row6;
	}

	#do custom sort
	usort($rows6,my_sorter);

	function my_sorter($a, $b){
		if ($a[post_title] == $b[post_title]) return 0;
		return ($a[post_title] > $b[post_title])?-1:1;
	}

	#display
	foreach($rows6 as $row6){
?>
	<a href="details.php?p=<?=$row6[ID]?>"><?=StripSlashes($row6['post_title'])?></a>
	<br>
<?
	}
?>