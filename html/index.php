<?php

// Init
chdir(dirname(__FILE__));
require_once '_init.php';

$data = [];

if (isset($_POST['view'])) {
	// Parsing
	$parser = new \MHOV\View\Parser();
	$container = $parser->parse($_POST['view']);
	$data['view'] = $container;
	
	// Renderer
	$renderer = new \MHOV\View\Renderer();
	$data['renderer'] = $renderer;
	
}

include(PAGE_DIR.'index.phtml');
