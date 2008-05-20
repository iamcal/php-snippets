<?php
	#
	# An implementation of the Porter Stemming Algorithm in PHP
	# ( see http://www.tartarus.org/~martin/PorterStemmer/ )
	#
	# (C)2005 Cal Henderson, <cal@iamcal.com>
	#
	# usage:   $stem = Porter_Stemmer::stem($word);
	#


	#
	# PHP4 doesn't have class variables, so we'll use the GLOBALS stash
	#

	$GLOBALS['Porter_Stemmer_step2list'] = array(
		'ational'=>'ate',
		'tional'=>'tion',
		'enci'=>'ence',
		'anci'=>'ance',
		'izer'=>'ize',
		'bli'=>'ble',
		'alli'=>'al',
		'entli'=>'ent',
		'eli'=>'e',
		'ousli'=>'ous',
		'ization'=>'ize',
		'ation'=>'ate',
		'ator'=>'ate',
		'alism'=>'al',
		'iveness'=>'ive',
		'fulness'=>'ful',
		'ousness'=>'ous',
		'aliti'=>'al',
		'iviti'=>'ive',
		'biliti'=>'ble',
		'logi'=>'log'
	);

	$GLOBALS['Porter_Stemmer_step3list'] = array(
		'icate'=>'ic',
		'ative'=>'',
		'alize'=>'al',
		'iciti'=>'ic',
		'ical'=>'ic',
		'ful'=>'',
		'ness'=>''
	);

	$GLOBALS['Porter_Stemmer_r'] = array(
		'c'	=> '[^aeiou]',			# consonant
		'v'	=> '[aeiouy]',			# vowel
		'c2'	=> '[^aeiou][^aeiouy]*',	# consonant sequence
		'v2'	=> '[aeiouy][aeiou]*',		# vowel sequence

		'mgr0'	=> '^([^aeiou][^aeiouy]*)?[aeiouy][aeiou]*[^aeiou][^aeiouy]*',						# [C]VC... is m>0
		'meq1'	=> '^([^aeiou][^aeiouy]*)?[aeiouy][aeiou]*[^aeiou][^aeiouy]*([aeiouy][aeiou]*)?$',			# [C]VC[V] is m=1
		'mgr1'	=> '^([^aeiou][^aeiouy]*)?[aeiouy][aeiou]*[^aeiou][^aeiouy]*[aeiouy][aeiou]*[^aeiou][^aeiouy]*',	# [C]VC[V] is m=1
		'_v'	=> '^([^aeiou][^aeiouy]*)?[aeiouy]',									# vowel in stem
	);


	#
	# the class really just puts the method in a namespace
	#

	class Porter_Stemmer {

		#
		# utility function to chop {x} chars from the end of a string
		#

		function end_chop($str, $len){
			return substr($str, 0, strlen($str)-$len);
		}

		#
		# the meat is here
		#

		function stem($w){

			# load into scope
			$r =& $GLOBALS['Porter_Stemmer_r'];
			$step2list =& $GLOBALS['Porter_Stemmer_step2list'];
			$step3list =& $GLOBALS['Porter_Stemmer_step3list'];


			$w = StrToLower($w);

			#
			# length at least 3
			#

			if (strlen($w) < 3) {
				return $w;
			}

			#
			# now map initial y to Y so that the patterns never treat it as vowel:
			#

			$firstch = substr($w, 0, 1);

			if ($firstch == 'y') {
				$w = ucfirst($w);
			}

			#
			# Step 1a
			#

			if (preg_match('/(ss|i)es$/', $w)){
				$w = Porter_Stemmer::end_chop($w, 2);
			}

			else if (preg_match('/([^s])s$/', $w)){
				$w = Porter_Stemmer::end_chop($w, 1);
			}

			#
			# Step 1b
			#

			if (preg_match('/eed$/', $w)) {
				$pre = Porter_Stemmer::end_chop($w, 3);

				if (preg_match("/$r[mgr0]/", $pre)) {
					$w = Porter_Stemmer::end_chop($w, 1);
				}
			}

			else if (preg_match('/(ed|ing)$/', $w, $m1)){

				$stem = Porter_Stemmer::end_chop($w, strlen($m1[1]));

				if (preg_match("/$r[_v]/", $stem)){

					$w = $stem;

					if (preg_match('/(at|bl|iz)$/', $w)) {
						$w .= "e";
					}

					else if (preg_match('/([^aeiouylsz])\1$/', $w)) {
						$w = Porter_Stemmer::end_chop($w, 1);
					}

					else if (preg_match("/^$r[c2]$r[v][^aeiouwxy]$/", $w)) {
						$w .= "e";
					}
				}
			}

			#
			# Step 1c
			#

			if (preg_match('/y$/', $w)) {

				$stem = Porter_Stemmer::end_chop($w, 1);

				if (preg_match("/$r[_v]/", $stem)){

					$w = $stem."i";
				}
			}

			#
			# Step 2
			#

			if (preg_match('/(ational|tional|enci|anci|izer|bli|alli|entli|eli|ousli|ization|ation|ator|alism|iveness|fulness|ousness|aliti|iviti|biliti|logi)$/', $w, $m1)){

				$suffix = $m1[1];
				$stem = Porter_Stemmer::end_chop($w, strlen($suffix));

				if (preg_match("/$r[mgr0]/", $stem)) {
					$w = $stem . $step2list[$suffix];
				}
			}

			#
			# Step 3
			#

			if (preg_match('/(icate|ative|alize|iciti|ical|ful|ness)$/', $w, $m1)){

				$suffix = $m1[1];
				$stem = Porter_Stemmer::end_chop($w, strlen($suffix));

				if (preg_match("/$r[mgr0]/", $stem)) {
					$w = $stem . $step3list[$suffix];
				}
			}

			#
			# Step 4
			#

			if (preg_match('/(al|ance|ence|er|ic|able|ible|ant|ement|ment|ent|ou|ism|ate|iti|ous|ive|ize)$/', $w, $m1)){

				$stem = Porter_Stemmer::end_chop($w, strlen($m1[1]));

				if (preg_match("/$r[mgr1]/", $stem)) {
					$w = $stem;
				}
			}

			else if (preg_match('/(s|t)(ion)$/', $w, $m1)){

				$stem = Porter_Stemmer::end_chop($w, strlen($m1[2]));

				if (preg_match("/$r[mgr1]/", $stem)) {
					$w = $stem;
				}
			}

			#
			#  Step 5
			#

			if (preg_match('/e$/', $w)) {

				$stem = Porter_Stemmer::end_chop($w, 1);

				$b1 = preg_match("/$r[mgr1]/", $stem);
				$b2 = preg_match("/$r[meq1]/", $stem);
				$b3 = preg_match("/^$r[c2]$r[v][^aeiouwxy]$/", $stem);

				if ($b1 || ($b2 && !$b3)) {
					$w = $stem;
				}
			}

			if (preg_match('/ll$/', $w) && preg_match("/$r[mgr1]/", $w)) {
				$w = Porter_Stemmer::end_chop($w, 1);
			}


			#
			# and turn initial Y back to y
			#

			if ($firstch == 'y') {
				$w = lcfirst($w);
			}

			return $w;
		}

	}

?>