<?php 
@ob_start();
session_start();
session_save_path("temp/");


	$_SESSION['userid']=$_REQUEST['userid']; 
	echo $_SESSION['userid'];
	

?>
