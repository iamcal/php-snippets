<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.implode.php
 * Type:     function
 * Name:     implode
 * Version:  1.0
 * Date:     Jan 09, 2003
 * Purpose:  implode an array
 * Input:
 *         - from = array to implode (required)
 *         - delim = delimiter to implode with (optional, default none)
 *         - none = output when the array is empty (optional, default none)
 *         - pre = string to prepend to each array entry (optional, default none)
 *         - post = string to append to each array entry (optional, default none)
 *
 * Example:  $foo = array('a', 'b', 'c');
 *           {implode from=$foo delim="," pre="[" post="]" none="Empty list!"} 
 * 
 * Output:   [a],[b],[c]
 *        
 * Install:  Just drop into the plugin directory.
 *          
 * Author:   Cal Henderson <cal@iamcal.com>
 * -------------------------------------------------------------
 */

	function smarty_function_implode($params){

		if (!count($params['from'])){
			return $params['none'];
		}

		$src = array();
		foreach($params['from'] as $item){
			$src[] = $params['pre'].$item.$params['post'];
		}

		return implode($params['delim'], $src);
	}

?>