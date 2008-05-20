<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     block.loop.php
 * Type:     block
 * Name:     loop
 * Version:  1.0
 * Date:     Sept 01, 2003
 * Purpose:  loop over a template block
 * Input:
 *         - count = number of time to loop (optional, default 2)
 *         - item = item to assign current loop value to (optional, default none)
 *
 * Example:  {loop count=3 item=i}line {$i}<br>{/loop} 
 * Output:   line 1<br>line 2<br>line 3<br>
 *        
 * Install:  Just drop into the plugin directory.
 *          
 * Author:   Cal Henderson <cal@iamcal.com>
 * -------------------------------------------------------------
 */

function smarty_block_loop($params, $content, &$smarty, &$repeat){

	#
	# get the iteration number
	#
	$stack_index = count($smarty->_tag_stack)-1;
	if ($smarty->_tag_stack[$stack_index][2]){
		$smarty->_tag_stack[$stack_index][2]++;
	}else{
		$smarty->_tag_stack[$stack_index][2] = 1;
	}
	$iter = $smarty->_tag_stack[$stack_index][2];

	#
	# set an item?
	#
	if (array_key_exists('item', $params)){
		$smarty->assign($params['item'], $iter);
	}

	#
	# should we repeat?
	#
	$count = 2;
	if (array_key_exists('count', $params)){
		$count = $params['count'];
	}	
	if ($iter <= $count){$repeat = 1;}

	#
	# output
	#
	if ($content != null){ echo $content; }
}

?>
