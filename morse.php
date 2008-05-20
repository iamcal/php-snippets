<?
	$fwd_morse = array(
		'A' => '.-',
		'B' => '-...',
		'C' => '-.-.',
		'D' => '-..',
		'E' => '.',
		'F' => '..-.',
		'G' => '--.',
		'H' => '....',
		'I' => '..',
		'J' => '.---',
		'K' => '-.-',
		'L' => '.-..',
		'M' => '--',
		'N' => '-.',
		'O' => '---',
		'P' => '.--.',
		'Q' => '--.-',
		'R' => '.-.',
		'S' => '...',
		'T' => '-',
		'U' => '..-',
		'V' => '...-',
		'W' => '.--',
		'X' => '-..-',
		'Y' => '-.--',
		'Z' => '--..',
		'0' => '-----',
		'1' => '.----',
		'2' => '..---',
		'3' => '...--',
		'4' => '....-',
		'5' => '.....',
		'6' => '-....',
		'7' => '--...',
		'8' => '---..',
		'9' => '----.',
		'.' => '.-.-.-',
		',' => '--..--',
		'?' => '..--..',
		':' => '---...',
		"'" => '.----.',
		'"' => '.-..-.',
		'-' => '-....-',
		'/' => '-..-.',
		'(' => '-.--.',
		')' => '-.--.-',
		'Ä' => '.-.-',
		'Á' => '.--.-',
		'Å' => '.--.-',
		'Ch' => '----',
		'É' => '..-..',
		'Ñ' => '--.--',
		'Ö' => '---.',
		'Ü' => '..--',
	);

	$rev_morse = array_flip($fwd_morse);

	function text_to_morse($msg){
		global $fwd_morse;

		$msg = StrToUpper($msg);
		$words = preg_split("/\s+/", $msg);

		$words_out = array();

		foreach($words as $word){

			$bits = array();

			for($i=0; $i<strlen($word); $i++){
				$temp = $fwd_morse[substr($word,$i,1)];
				if ($temp) $bits[] = $temp;
			}
			$words_out[] = implode(' ', $bits);
		}
		return implode(' / ', $words_out);

	}

	function morse_to_text($msg){
		global $rev_morse;

		#$msg = preg_replace("/[^.\/-]/", "", $msg);
		$bits = preg_split("/\s+/", $msg);
		$out = '';
		foreach($bits as $bit){
			if ($bit == '/'){
				$out .= " ";
			}else{
				$out .= $rev_morse[$bit];
			}
		}
		return $out;
	}

	$morse = StripSlashes($morse);
	$text = StripSlashes($text);

	if ($action == 't2m') $morse = text_to_morse($text);
	if ($action == 'm2t') $text = morse_to_text($morse);


?>

<form action="morse.php" method="post">
<input type="hidden" name="action" value="t2m">
Text:<br>
<textarea cols="40" rows="6" name="text"><?=htmlentities($text)?></textarea><br>
<input type="submit" value="Text To Morse">
</form>


<form action="morse.php" method="post">
<input type="hidden" name="action" value="m2t">
Morse:<br>
<textarea cols="40" rows="6" name="morse"><?=htmlentities($morse)?></textarea><br>
<input type="submit" value="Morse To Text">
</form>
