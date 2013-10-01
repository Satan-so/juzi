<?php require_once 'authentication.php'; ?>
<!DOCTYPE HTML>
<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<style>
	form {border: 1px solid #ccc; padding: 10px; margin-right: 200px;}
	form #addr {width: 400px;}
</style>
</head>
<body>

<?php
$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
require_once '../dbHelper.php';
$shop = dbHelper::fetchOne('SELECT * FROM `shop` WHERE id = ' . $id);

echo '<form action="update.php?id=' . $id . '" method="post">';
echo '<p>店名：<input type="text" name="name" value="' . $shop['name'] . '" /></p>';
echo '<p>地址：<input type="text" name="addr" value="' . $shop['addr'] . '" id="addr" /></p>';
echo '<p>标签：<input type="text" name="tag" value="'. $shop['tag'] . '" /></p>';
?>
<input type="submit" value="更新" />
</form>

</body>
</html>
