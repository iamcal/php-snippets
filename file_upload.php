<?
	# this is our sexy routine

	function upload_a_file($field, $path){
		global $HTTP_POST_FILES;

		if ($HTTP_POST_FILES[$field]['name'] != ""){
			$src = $HTTP_POST_FILES[$field]['tmp_name'];
			if (is_uploaded_file($src)){
				$dest = trim($HTTP_POST_FILES[$field]['name']);
				$i=0;
				while(file_exists("$path/$dest")){
					$dest = $i.'_'.trim($HTTP_POST_FILES[$field]['name']);
					$i++;
				}
				copy($src,"$path/$dest");
				return $dest;
			}
		}
		return 0;
	}

	# see if a file has been uploaded
	$path = '/path/to/where/i/want/the/file';
	$file = upload_a_file('myfile',$path);

	if ($file){
		echo "a file has been uploaded here: $path/$file<br><br>";
	}

?>

<form method="post" enctype="multipart/form-data">
Upload a file:<br>
<input type="file" name="myfile"> <input type="submit">
</form>

