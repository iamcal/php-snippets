<?
	$data = preg_replace("/[^01]/","",$data);

	function dodata($data){
		$out = '';
		while($data){
			$block = substr($data,0,8);
			$data = substr($data,8);
			$out .= chr(bindec($block));
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