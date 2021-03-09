<?php

if (!config::$upload) do404();


if (!empty($_FILES)) {

	$tmp_name = $_FILES['file']['tmp_name'];
	$name     = $_FILES['file']['name'];



	if (
		(strpos($name, '/')) ||
		(substr($name, 0, 1) == '.') ||
		(substr($name, 0, 1) == '~') ||
		(!isset($name))
	) {
		do404();
	}


	$target_file = config::$dir.'/'.$name;
	move_uploaded_file($tmp_name, $target_file);
} else {
	do404();
}


?>
