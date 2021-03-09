<?php


class dumpload {
	protected string $dir;
	protected bool   $delete;
	protected array  $files;
	protected string $base;

	protected string $dwn;
	protected string $del;

	public function __construct(
		string $dir    = null,
		bool   $delete = null,
		bool   $icons  = null,
		string $base   = null
	) {

		// This is already checked in the config static class
		$this->dir    = $dir ?: \config::$dir;
		$this->delete = $delete ?: \config::$delete;
		$this->base   = $base ?: $_SERVER["SCRIPT_NAME"];
		$icons = $icons ?: \config::$icons;


		$files = scandir($this->dir);
		$times = array();

		foreach ($files as $f) {
			if (substr($f, 0, 1) == '.') continue;
			if ($f == "README") continue;
			$times[$f] =  filemtime($this->dir.'/'.$f);
		}

		asort($times, SORT_NUMERIC);
		$this->files = array_reverse($times);

		if ($icons) {
			$this->dwn = "&#x21af;";
			$this->del = "&#x1f6ab;";
		} else {
			$this->dwn = "[DL]";
			$this->del = "[DEL]";
		}


	}

	protected function human_filesize(int $size): string {
		$mod = 1024;
		$units = explode(' ','b kB MB GB TB PB');
		for ($i = 0; $size > $mod; $i++) {
			$size /= $mod;
		}

		return round($size, 2) . ' ' . $units[$i];
	}


	public function table(): string {

		$return =
			"<table>\n".
			"<thead><tr><th>File</th><th>Size</th><th>Date</th><th>Actions</th></tr></thead>\n".
			"<tbody>\n";


		foreach ($this->files as $file=>$stamp) {
			$full_file = $this->dir.'/'.$file;
			if (is_dir($full_file)) continue;
			$url_file  = urlencode($file);
			
			$size   = filesize($full_file);
			$h_size = $this->human_filesize($size);
			$date   = date("Y-d-m H:i:s", $stamp);

			$return .=
				"<tr>\n".
				"<td><a href='{$this->base}/get/$url_file'>$file</a></td>\n".
				"<td title='size in bytes: $size'>$h_size</td>\n".
				"<td class='time' title='$date' rawtime='$stamp'>$date</td>\n".
				"<td class='actions'>".
				"<a title='Download $file' href='{$this->base}/dl/$url_file'>{$this->dwn}</a>";

			if ($this->delete) $return .=  "&nbsp;<a class='delete' title='Delete $file' href='{$this->base}/del/$url_file'>{$this->del}</a>";

			$return .= "</td>\n</tr>\n";
		}

		$return .= "</tbody>\n</table>\n";

		return $return;


	}

}


