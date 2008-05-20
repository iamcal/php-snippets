<?php

	function insert_date_editor($name, $when = 0){

		if (!$when){$when = time();}

		echo "<select name=\"{$name}_d\">\n";
		for($i=1; $i<=31; $i++){
			$sel = ($i == date('d', $when))?' selected':'';
			$label = date('jS',mktime(0,0,0,1,$i,2000));
			echo "<option value=\"$i\"$sel>$label</option>\n";
		}
		echo "</select>\n";

		echo "<select name=\"{$name}_m\">\n";
		for($i=1; $i<=12; $i++){
			$sel = ($i == date('m', $when))?' selected':'';
			$label = date('F',mktime(0,0,0,$i,1,2000));
			echo "<option value=\"$i\"$sel>$label</option>\n";
		}
		echo "</select>\n";

		echo "<select name=\"{$name}_y\">\n";
		for($i=2003; $i<=2010; $i++){
			$sel = ($i == date('Y', $when))?' selected':'';
			echo "<option value=\"$i\"$sel>$i</option>\n";
		}
		echo "</select>\n";
	}

?>