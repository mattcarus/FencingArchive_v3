<?php

/** Universal AJAX Proxy
 *
 *  Usage:
 *    ajaxproxy.php?get=<url (url encoded)
 *  
 *  Example:
 *    ajaxproxy.php?get=
 */

$requestedUrl = urldecode($_GET['get']);

echo file_get_contents($requestedUrl);

?>