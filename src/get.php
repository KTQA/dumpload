<?php

if (substr($file, 0, 1) == '.' || strpos("README", $file)) do404();
$fname = config::$dir.'/'.$file;
if (!file_exists($fname)) do404();


if ($method == "del") {
	if (config::$delete == false) do404();
	if (!unlink($fname)) {
		echo "Deleting file failed for some reason.\n";
		exit();
	}
	echo "Done.\n";

} else {
	header("Content-type: ".mime_content_type($fname));
	if ($method == "dl") header("Content-Disposition: attachment; filename=\"$file\"");
	header("X-Sendfile: $fname");

}


