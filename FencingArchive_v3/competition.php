<?php

	/**
	 * Stub file for redirect to new-style urls
	 */

	header("HTTP/1.1 301 Moved Permanently");
	header("Location: http://fencingarchive.net/competition/" . $_GET['id']);
	
?>