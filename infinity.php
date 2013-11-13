<?php
require_once 'dbHelper.php';
require_once 'infinity_script.php';

class infinity{

	public function ack($req, $user) {
		$uid = $user['id'];
		dbHelper::query("UPDATE `users` SET act = 11 WHERE id = '$uid'");

		if ($req == '退出') {
			dbHelper::query("UPDATE `users` SET act = 0 WHERE id = '$uid'");
			$step = infinityScript::$script['-1'];

		} else if ($req == '新的开始') {
			dbHelper::query("UPDATE `infinity_users` SET step = 0 WHERE uid = '$uid'");
			$step = infinityScript::$script['0'];

		} else {
			$step = $this->getStep($uid);

			if($step[$req]) {
				$stepId = $step[$req];
				dbHelper::query("UPDATE `infinity_users` SET step = $stepId WHERE uid = '$uid'");
				$step = infinityScript::$script[$stepId];
			}
		}

		return $step['text'];
	}

	private function getStep($uid) {
		$res = dbHelper::fetchOne("SELECT * FROM `infinity_users` WHERE uid = '$uid'");

		if (!$res) {
			dbHelper::query("INSERT INTO `infinity_users` (uid) VALUES ('$uid')");
			$res = dbHelper::fetchOne("SELECT * FROM `infinity_users` WHERE uid = '$uid'");
		}

		return infinityScript::$script[$res['step']];
	}
}