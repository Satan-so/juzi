<?php

// echo phpinfo();
// exit;

require_once('juzi.php');
$juzi = new juzi();
echo $juzi->ack('西财默示录', 'test');

exit;

require_once('thumb.php');
$t = new ThumbHandler();
//给图片增加水印
$t->setSrcImg('fqbg.jpg');
$t->setDstImg('tmp/0.jpg');
$t->setMaskFont('hksnt.ttf');
$t->setMaskFontColor('#000000');
$text = '爸爸我爱你！爸爸我爱你！爸爸我爱你！爸爸我爱你！';
var_dump($text);
$text = wordwrap($text, 10);
var_dump($text);
$t->setMaskWord($text);
//$t->setMaskImg("./img/test.gif");
$t->setMaskPosition(1);
$t->setMaskOffsetX(80);
$t->setMaskOffsetY(88);
//$t->setMaskImgPct(80);
//$t->setDstImgBorder(4,"#dddddd");

// 指定缩放比例
$t->createImg(300, 300);


