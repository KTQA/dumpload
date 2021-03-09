<?php


$d = new dumpload();
$table = $d->table();

// If we just need the table for post-(upload||delete) 
if (isset($_REQUEST["t"])) {
	echo $table;
	exit;
}


// figure out what css/js we're gonna need, include them inline
$css = file_get_contents("dumpload.css");
$js = file_get_contents("js/dumpload.js");
if (config::$delete) $js .= "\n" . file_get_contents("js/delete.js");

if (config::$upload) {

	$js .= 
		"\n" . file_get_contents("dropzone/dropzone.min.js").
		"\n" . file_get_contents("js/upload.js");

		
	$css .= "\n" . file_get_contents("dropzone/dropzone.min.css");

}

// poot some html
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=config::$title?></title>
	<style><?=$css?></style>
	<script><?=$js?></script>
</head>
<body>
	<h1><?=config::$title?></h1>
	<?php

		printf("<input type='hidden' id='_sn' value='%s' />\n", $_SERVER["SCRIPT_NAME"]);


		if (config::$age) {
			printf("<input type='hidden' id='age' value='%d' />\n", config::$age);
		}


		if (file_exists(config::$dir.'/README')) {
			printf("\t<pre>\n%s\n\t</pre>\n", file_get_contents(config::$dir.'/README'));
		}

		if (config::$upload) {
			// looks nicer, don't it?
			printf("<form action='%s/upload' id='upload' class='dropzone'></form>\n",  $_SERVER["SCRIPT_NAME"]);
		}


	?>
	<div id="list">
		<?=$table?>
	</div>
</body>
</html>
