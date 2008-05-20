<?php

	/*
	* Smarty plugin
	* -------------------------------------------------------------
	* File:		block.loop.php
	* Type:		block
	* Name:		loop
	* Purpose:	loop over a template block
	* Version:
	*		1.1, Nov 16 2004
	*		- fixed iteration count of zero
	*
	* 		1.0, Sep 01 2003
	*		- initial release
	*
	* Input:
	*		- count = number of time to loop (optional, default 2)
	*		- item = item to assign current loop value to (optional, default none)
	*
	* Example:	{loop count=3 item=i}line {$i}<br>{/loop}
	* Output:	line 1<br>line 2<br>line 3<br>
	*
	* Install:	Just drop into the plugin directory.
	*
	* Author:	Cal Henderson <cal@iamcal.com>
	* -------------------------------------------------------------
	*/

	function smarty_block_loop($params, $content, &$smarty, &$repeat){

		#
		# get the iteration number
		#

		$stack_index = count($smarty->_tag_stack)-1;

		$iteration = $smarty->_tag_stack[$stack_index][2];
		$iteration = $iteration ? $iteration + 1 : 1;

		$smarty->_tag_stack[$stack_index][2] = $iteration;


		#
		# set an item?
		#

		if (array_key_exists('item', $params)){
			$smarty->assign($params['item'], $iteration);
		}


		#
		# should we repeat?
		#

		$count = array_key_exists('count', $params) ? $params['count'] : 2;

		if ($iteration <= $count){
			$repeat = 1;
		}


		#
		# output
		#

		if (($content != null) && ($iteration-1 <= $count)){
			echo $content;
		}
	}

?>
