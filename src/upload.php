<?php

if (!config::$upload) do404();


if (!empty($_FILES)) {

	$tmp_name = $_FILES['file']['tmp_name'];
	$name     = $_FILES['file']['name'];
	$target_file = config::$dir.'/'.$name;
	



	if (
		(strpos($name, '/')) ||
		(strpos($name, "README")) ||
		(substr($name, 0, 1) == '.') ||
		(substr($name, 0, 1) == '~') ||
		(!isset($name))
	) {
		do404();
	}

	if (file_exists($target_file)) do400("file exists!");

	move_uploaded_file($tmp_name, $target_file);
} else {
	do404();
}


?>
