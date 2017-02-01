<?php
session_start();
require ('Illusion.php');
$db = new Database;

$id = ( isset( $_REQUEST['id'] ) ) ? $_REQUEST['id'] : '';

if ($id != '' ){
$me = $db->delete(null,"id=$id");

	if ($me === true ){
		$_SESSION['message'] = "Record Deleted";
		header("location: ./");
	}
	else {
		$_SESSION['message'] = "Error Deleting Record..!";
		header("location: ./");
	}
}
else {
	header("location: ./");
}