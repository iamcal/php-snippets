<?php

	function db_process_hash($hash){
		$out = array();
		foreach(array_keys($hash) as $k){
			$out["`$k`"] = "'$hash[$k]'";
		}
		return $out;
	}

	function db_insert($table, $hash){
		global $db;

		$hash = db_process_hash($hash);

		$fields = implode(', ', array_keys($hash));
		$data = implode(', ', $hash);
		mysql_query("INSERT INTO $table ($fields) VALUES ($data)", $db);
		return mysql_insert_id();
	}

	function db_update($table, $hash, $id){
		if (!$id){ return db_insert($table, $hash); }
		global $db;

		$hash = db_process_hash($hash);

		$data = array();
		foreach(array_keys($hash) as $k){
			$data[] = "$k = $hash[$k]";
		}
		$data = implode(', ', $data);
		mysql_query("UPDATE $table SET $data WHERE id=$id", $db);
		return $id;
	}

?>