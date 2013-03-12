<?php

$dir = dirname(__FILE__);

foreach (glob("$dir/*.php") as $filename) {
	if ($filename !== __FILE__) {
		include_once($filename);
	}
}