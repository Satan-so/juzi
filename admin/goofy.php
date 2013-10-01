<?php require_once 'authentication.php'; ?>
<!DOCTYPE HTML>
<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<style>
	form {border: 1px solid #ccc; padding: 10px; margin-right: 200px;}
	form #content {width: 400px;}
</style>
</head>
<body>

<form action="add_goofy.php" method="post">
<input type="text" name="content" id="content" />
<input type="submit" value="添加" />
</form>

<ul>
<?php
	require_once '../dbHelper.php';
	$rows = dbHelper::fetchAll('SELECT * FROM `goofy` ORDER BY id DESC');

	foreach ($rows as $row) {
		echo '<li>';
		echo $row['content'];
		echo '</li>';
	}
?>
</ul>

</body>
</html>
