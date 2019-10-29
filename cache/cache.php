<?php

// Checks whether the page has been cached or not
function is_cached($file) {
	$cachefile = '../cache/' . $file;
	$cachefile_created = (file_exists($cachefile)) ? @filemtime($cachefile) : 0;
	return ((time() - 3600) < $cachefile_created);
}

// Reads from a cached file
function read_cache($file) {
	$cachefile = '../cache/' . $file;
	return file_get_contents($cachefile);
}

// Writes to a cached file
function write_cache($file, $out) {
	$cachefile = '../cache/' . $file;
	$fp = fopen($cachefile, 'w');
	fwrite($fp, $out);
	fclose($fp);
}

// Let's begin, first work out the cached filename
$cache_file = md5($params) . '.json';

// Check if it has already been cached and not expired
// If true then we output the cached file contents and finish
if (is_cached($cache_file)) {
	read_cache($cache_file);
	exit();
}
