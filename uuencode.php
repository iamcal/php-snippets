<?
	###############################################################################

	function uudecode_data_block($data){
		if (preg_match("!begin [^\s]+ [^\s]+\n(.*)\nend\n!s", $data, $matches)){
			return uudecode_data($matches[1]);
		}
	}

	###############################################################################

	function uudecode_data($data){

		$data = preg_replace('![^\x20-\x5f\n]!', '', $data);

		$buffer = '';

		$lines = explode("\n", $data);

		foreach($lines as $line){

			$len = ord($line{0}) - 0x20;

			$cursor = 1;
			while($cursor < strlen($line)){
				$b1 = ord($line{$cursor+0});
				$b2 = ord($line{$cursor+1});
				$b3 = ord($line{$cursor+2});
				$b4 = ord($line{$cursor+3});

				$b1 -= 0x20;
				$b2 -= 0x20;
				$b3 -= 0x20;
				$b4 -= 0x20;

				# b1       b2       b3       b4
				# 87654321 87654321 87654321 87654321 
				# 
				# A: b1(654321)b2(65)
				# B: b2(4321)b3(6543)
				# C: b3(21)b4(654321)

				$a = (($b1 << 2) & 0xFC) | (($b2 >> 4) & 0x03);
				$b = (($b2 << 4) & 0xF0) | (($b3 >> 2) & 0x0F);
				$c = (($b3 << 6) & 0xC0) | (($b4 >> 0) & 0x3F);

				$buffer .= chr($a).chr($b).chr($c);

				$cursor += 4;
			}
		}

		return $buffer;
	}

	###############################################################################
?>