<?php

define('CLASS_DIR', '../src/');
define('PAGE_DIR', '../pages/');
set_include_path(get_include_path().PATH_SEPARATOR.CLASS_DIR);

// PSR-4 Autoload
spl_autoload_register(function ($class) {
	
	$prefix = 'MHOV\\';
	
	// does the class use the namespace prefix?
	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0) {
		// no, move to the next registered autoloader
		return;
	}
	// get the relative class name
	$relative_class = substr($class, $len);
	
	// replace the namespace prefix with the base directory, replace namespace
	// separators with directory separators in the relative class name, append
	// with .php
	$file = CLASS_DIR . str_replace('\\', '/', $relative_class) . '.php';
	
	// if the file exists, require it
	if (file_exists($file)) {
		require $file;
	}
});