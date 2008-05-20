<?
	$data = preg_replace("/[^01]/","",$data);

	function dodata($data){
		$out = '';
		while($data){
			$block = substr($data,0,8);
			$val = bindec($block);
			$ch = chr($val);
			$out .= $ch;
			$data = substr($data,8);
			echo "$block -&gt; $val -&gt; $ch<br>";
		}
		return $out;
	}

?>

<? if ($data){ ?>
	Message: "<?=dodata($data)?>"<br>
	<br>
<? } ?>
<form method="post">
<textarea name="data" wrap="virtual" col="30" rows="10"></textarea><br>
<input type="submit" value="go">
</form>