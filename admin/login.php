<?php

if ($_POST['passwd'] == 'gqzl') {
	session_start();
	$_SESSION['login'] = 1;
	header('Location:index.php');
} else {
	header('Location:index.html');
}