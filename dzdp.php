<?php

require_once 'simple_html_dom.php';

$url = 'http://www.dianping.com/search/category/8/10/r4959o3p1';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; U; Linux i686; zh-CN; rv:1.9.1.2) Gecko/20090803 Fedora/3.5.2-2.fc11 Firefox/3.5.2');
$content = curl_exec($ch);
curl_close($ch);
$html = str_get_html($content);

$conn = mysql_connect('MYSQL1002.webweb.com', '989ce8_juzi', 'swufejuzi');

if (!$conn) {
	die('Could not connect: ' . mysql_error());
}

mysql_select_db('db_989ce8_juzi', $conn);
mysql_query('set names utf8;');

foreach($html->find('ul.detail') as $item) {
	$name = $item->find('li.shopname a');
	$name = $name[0]->title;
	var_dump($name);

	$addr = $item->find('li.address');
	$addr = $addr[0]->text();
	$addr = str_replace('地址:', '', $addr);
	$addr = html_entity_decode($addr, ENT_COMPAT, 'UTF-8');
	var_dump($addr);

	$sql = "INSERT INTO shop (name, addr) VALUES ('$name','$addr')";

	if (!mysql_query($sql, $conn)) {
  		die('Error: ' . mysql_error());
  	}
}

mysql_close($conn);