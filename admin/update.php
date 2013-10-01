<?php

require_once 'authentication.php';

$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
$name = $_POST['name'];
$addr = $_POST['addr'];
$tag = $_POST['tag'];

if ($name) {
	require_once '../dbHelper.php';
	$sql = "update `shop` SET `name` = '$name', `addr` = '$addr', `tag` = '$tag' WHERE `id` = $id";
	dbHelper::query($sql);
}

header('Location:index.php');