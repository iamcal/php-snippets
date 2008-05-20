<?
	if ($email){
		mail('gpnewslist-request@gotplayed.com', 'subscribe', '', "From: $email");

		header("location: page_to_go_to.php");
		exit;
	}
?>

<form action="this_page.php" method="post">

<input type="text" name="email">

<input type="subscribe">

</form>
