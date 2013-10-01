<?php

require_once 'authentication.php';

$name = $_POST['name'];
$addr = $_POST['addr'];

if ($name) {
	require_once '../dbHelper.php';
	$sql = "INSERT INTO shop (name, addr) VALUES ('$name','$addr')";
	dbHelper::query($sql);
}

header('Location:index.php');