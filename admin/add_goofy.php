<?php

require_once 'authentication.php';

$content = $_POST['content'];

if ($content) {
	require_once '../dbHelper.php';
	$sql = "INSERT INTO goofy (content) VALUES ('$content')";
	dbHelper::query($sql);
}

header('Location:goofy.php');