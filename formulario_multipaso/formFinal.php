<?php

//let's start our session, so we have access to stored data
	session_start();

$bodyOutput = "<p>".$_SESSION['name']."</p>";

include_once('./templates/final.tlp.php');

?>



