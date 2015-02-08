<?php
    require_once('functions.php');
    // just so we know it is broken
    error_reporting(E_ALL);
    // some basic sanity checks
    if(isset($_GET['image_id']) && is_numeric($_GET['image_id'])) {
        //connect to the db
        connect_db();
 
        // get the image from the db
        $sql = "SELECT image FROM images WHERE id=" . $_GET['image_id'];
 
        // the result of the query
        $result = mysql_query("$sql") or die("Invalid query: " . mysql_error());
 
        // set the header for the image
        header("Content-type: image/jpeg");
        echo mysql_result($result, 0);
 
        // close the db link
        mysql_close();
    }
    else {
        echo 'Please use a real id number';
    }
?>
