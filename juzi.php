<?php
require_once 'dbHelper.php';

class juzi {
	public function ack($req, $uid) {
		$user = $this->getUser($uid);
		$act = $user['act'];

		if ($req == '西财默示录' || ($act == 11)) {
			return $this->infinity($req, $user);

		} elseif ($act > 0) {
			return $this->doAct($req, $uid, $act);

		} elseif ($req == '测试') {
			return $this->ceshi($req, $uid, $act);

		} elseif (strpos($req, '么么哒') !== false) {
			return '么么哒~';

		} elseif ($req == '随便吃' || $req == 'sbc') {
			return $this->randomEat();

		} elseif (strpos($req, '想吃') !== false) {
			return $this->wantEat($req);

		} elseif ($req == '笑话' || $req == 'xh') {
			return $this->goofy();

		} elseif (strpos($req, '讲笑话') === 0 && mb_strlen($req) > 5) {
			return $this->addGoofy($req, $uid);

		} elseif (strpos($req, 'redis') === 0) {
			return $this->redis($req);

		// } elseif (strpos($req, '爸爸') === 0 && mb_strlen($req) > 1) {
		// 	return $this->father($req);

		} else {
			return $this->def($req);

		}
	}

	private function getUser($uid) {
		$res = dbHelper::fetchOne("SELECT * FROM `users` WHERE openId = '$uid'");

		if (!$res) {
			dbHelper::query("INSERT INTO `users` (openId) VALUES ('$uid')");
			$res = dbHelper::fetchOne("SELECT * FROM `users` WHERE openId = '$uid'");
		}

		return $res;
	}

	private function doAct($req, $uid, $act) {
		$nextAct = $act * 10 + $req;
		$next = dbHelper::fetchOne("SELECT * FROM `act` WHERE act = $nextAct");

		if ($next) {
			if ($next['type'] == 0) {
				dbHelper::query("UPDATE `users` SET act = 0 WHERE openId = '$uid'");
			} else {
				dbHelper::query("UPDATE `users` SET act = $nextAct WHERE openId = '$uid'");
			}
			
			return $next['text'];
		} else {
			$act = dbHelper::fetchOne("SELECT * FROM `act` WHERE act = $act");
			return $act['text'];
		}
	}

	private function def($req) {
		// $default = "\n\n发送“随便吃”或“sbc”，让贴心的橘子学姐帮你挑选去吃什么~\n发送“想吃*”（如“想吃抄手”），询问橘子学姐的建议~\n发送“测试”和橘子学姐一起做心理测试~\n发送“笑话”或“xh”，听橘子学姐讲笑话！\n发送“爸爸+想说的话”（如“爸爸我爱你”）让橘子学姐帮你制作父亲节贺卡~";
		$default = "\n\n发送“随便吃”或“sbc”，让贴心的橘子学姐帮你挑选去吃什么~\n发送“想吃*”（如“想吃抄手”），询问橘子学姐的建议~\n发送“测试”和橘子学姐一起做心理测试~\n发送“笑话”或“xh”，听橘子学姐讲笑话！\n\n发送“西财默示录”，参与橘子学姐出品必属精品的游戏内测~~~~";
		
		// require_once 'simsimi.php';
		// $simsimi = new simsimi();

		// do {
		// 	$res = $simsimi->ack($req);
		// } while (strpos($res, '黄鸡') !== false);
		
		$res = '橘子学姐先记下了，等我自习回来再回复你哦！';
		return $res . $default;
	}

	private function randomEat() {
		$res = dbHelper::fetchOne('SELECT * FROM `shop` ORDER BY rand() LIMIT 1');

		return '橘子学姐推荐你去吃：' . $res['name'] . "\n地址：" . $res['addr'] . "\n\n如果不喜欢，就让橘子学姐再随便一次吧！";
	}

	private function wantEat($food) {
		$food = mb_substr($food, 2, 2, 'UTF-8');

		if ($food == '翔') {
			return '江女神最好吃了！';
		}

		$res = dbHelper::fetchOne("SELECT * FROM `shop` WHERE tag LIKE '%$food%' ORDER BY rand() LIMIT 1");

		if ($res) {
			return '橘子学姐推荐你去吃：' . $res['name'] . "\n地址：" . $res['addr'];
		} else {
			return '橘子学姐也不知道哪的' . $food . '最好吃。。。';
		}
		
	}

	private function ceshi($req, $uid, $act) {
		$act = dbHelper::fetchOne("SELECT * FROM `act` WHERE act >= 1000 AND act <= 1099 ORDER BY rand() LIMIT 1");
		$actId = $act['act'];
		dbHelper::query("UPDATE `users` SET act = $actId WHERE openId = '$uid'");

		return $act['text'];
	}

	private function goofy() {
		$res = dbHelper::fetchOne('SELECT * FROM `goofy` ORDER BY rand() LIMIT 1');

		return $res['content'] . "\n\n不好笑么？那发送“讲笑话+笑话内容”给橘子学姐讲一个笑话吧！";
	}

	private function addGoofy($goofy, $uid) {
		$goofy = mb_substr($goofy, 3, 255, 'UTF-8');
		$sql = "INSERT INTO goofy (content, uid) VALUES ('$goofy', '$uid')";
		dbHelper::query($sql);

		$res = array(
			'呵呵~',
			'噗！',
			'好好笑啊！',
			'橘子学姐笑惨咯~',
			'点都不好笑。。。',
		);

		return $res[array_rand($res)];
	}

	private function father($req) {
		$req = mb_substr($req, 2, 20, 'UTF-8');

		require_once('thumb.php');
 
 		$file = 'tmp/' . time() . '.jpg';
		$t = new ThumbHandler();
		$t->setSrcImg('fqbg.jpg');
		$t->setDstImg($file);
		$t->setMaskFont('hksnt.ttf');
		$t->setMaskFontColor('#000000');
		$t->setMaskWord($req);
		$t->setMaskPosition(1);
		$t->setMaskOffsetX(80);
		$t->setMaskOffsetY(88);
		$t->createImg(300, 300);

		return '橘子学姐已经把你对粑粑说的话写进了一张贺卡，快点开看一下吧！ http://juzi.satan.so/' . $file;

		// return array(
		// 	'title' => '父亲节贺卡',
		// 	'des' => '橘子学姐已经把你对粑粑说的话写进了一张贺卡，快点开看一下吧' . $url,
		// 	'pic' => $url,
		// 	'url' => $url);
	}

	private function infinity($req, $user) {
		require_once('infinity.php');

		$infinity = new infinity();
		return $infinity->ack($req, $user);
	}

	private function redis($req) {
		if ($req == 'redis') {
			return '输入“redis实例名”查看Redis状态';
		}

		$name = substr($req, 5);
		return file_get_contents("http://ops.juangua.com/redis/wx.php?name={$name}");
	}
}