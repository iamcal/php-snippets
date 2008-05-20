<?
	include('init.php');

	if ($done){
		# do processing...

		header("location: page_to_go_to.php");
		exit;
	}
?>

<form>

<input type="hidden" name="done" value="1">

<input type="text" name="woo">

<input type="submit">

</form>
