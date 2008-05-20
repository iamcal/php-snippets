<?
	#
	# some code to stop double posting
	# by cal
	#

	# grab the last post by this user
	$last_post_row = mysql_fetch_array(mysql_query("SELECT * FROM posts WHERE user_id='$user' ORDER BY post_time DESC LIMIT 1",$db));

	# compare against the message they just posted
	if (AddSlashes($last_post_row[message]) != $message){

		# it's different - put the message in the database
		$time = time();
		$result = mysql_query("INSERT INTO posts (user_id, message, post_time) VALUES ('$user', '$message', $time)",$db);
		$post_num = mysql_insert_id();

	}else{

		# it's the same message - hold onto the old message id
		$post_num = $last_post_row[id];
	}

?>