<?php

class config {

	static public string $title;
	static public string $dir;
	static public bool $upload;
	static public bool $delete;
	static public bool $icons;
	static public int $age;


	static public function init() {

		$dir = getenv("DUMPLOADDIR");

		if (trim($dir) == "") {
			printf("please set the DUMPLOADDIR environment variable");
			exit(1);
		} else if (!is_readable($dir)) {
			printf("directory '%s' is not readable\n", $dir);
			exit(1);
		}
		self::$dir = $dir;

		$file = self::$dir."/.dumpload.ini";
		if (is_readable($file)) {

			$raw = parse_ini_file($file, true, INI_SCANNER_TYPED);
			if ($raw === false) {
				printf("'%s' is nonsensical.\n", $file);
				exit(1);
			}
		}

		@self::$title  = $raw["title"] ?: self::$dir;
		@self::$upload = (bool) $raw["upload"] ?: false;
		@self::$delete = (bool) $raw["delete"] ?: false;
		@self::$age    = (int) $raw["age"] ?: 0;
		@self::$icons  = (bool) $raw["icons"] ?: true;


		if (self::$upload == true && is_writeable(self::$dir) == false) {
			printf("allow upload is specified and directory '%s' isn't writeable\n", self::$dir);
			exit(1);
		}

		
		if (self::$delete == true && is_writeable(self::$dir) == false) {
			printf("allow delete is specified and directory '%s' isn't writeable\n", self::$dir);
			exit(1);
		}


	}
}

function do404() {
	http_response_code(404);
	echo "<html><body><h1>404 &mdash; haha, no.</h1></body></html>\n";
	exit;
}

function do400(string $str = "Unknown error.") {
	http_response_code(400);
	echo "<html><body><h1>400 &mdash; $str</h1></body></html>\n";
	exit;
}



require("dumpload.class.php");

config::init();

//header("Content-type: text/plain");
//print_r($_SERVER);

@preg_match("#^/([a-z]{2,6})/?([^/]*)?#", $_SERVER["PATH_INFO"], $m);

if (count($m) == 0) {
	$method = "index";
	$file = null;
} else {
	$method = $m[1];
	$file = urldecode($m[2]);
}

switch ($method) {
	case "index":
		require("index.php");
		break;

	case "get":
	case "dl":
	case "del":
		require("get.php");
		break;

	case "table":
		$t = new dumpload();
		echo $t->table();
		break;

	case "upload":
		require("upload.php");
		break;

	default:
		do404();
		break;
}







