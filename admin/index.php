<?php require_once 'authentication.php'; ?>
<!DOCTYPE HTML>
<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<style>
	form {border: 1px solid #ccc; padding: 10px; margin-right: 200px;}
	form #addr {width: 400px;}
	.name {width:200px; font-weight: bold; display: inline-block;}
</style>
</head>
<body>

<a href="goofy.php">添加笑话</a>

<form action="add.php" method="post">
店名：<input type="text" name="name" />
地址：<input type="text" name="addr" id="addr" />
<input type="submit" value="添加" />
</form>

<ul>
<?php
	require_once '../dbHelper.php';
	$rows = dbHelper::fetchAll('SELECT * FROM `shop` ORDER BY id DESC');

	foreach ($rows as $row) {
		echo '<li>';
		echo '<a class="name" href="edit.php?id=' . $row['id'] . '">' . $row['name'] . '</a>';
		echo '<span class="addr">' . $row['addr'] . '</span>';
		echo '</li>';
	}
?>
</ul>

</body>
</html>
