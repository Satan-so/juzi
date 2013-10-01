<?php

class dbHelper {
	const addr = 'MYSQL1002.webweb.com';
	const user = '989ce8_juzi';
	const passwd = 'swufejuzi';
	const db = 'db_989ce8_juzi';

	public static function fetchOne($sql) {
		return mysql_fetch_assoc(self::query($sql));
	}

	public static function fetchAll($sql) {
		$rows = self::query($sql);
		$res = array();

		while ($row = mysql_fetch_assoc($rows)) {
			$res[] = $row;
		}

		return $res;
	}

	public static function query($sql) {
		$conn = mysql_connect(self::addr, self::user, self::passwd);
		
		if (!$conn) {
			die('Could not connect: ' . mysql_error());
		}

		mysql_select_db(self::db, $conn);
		mysql_query('set names utf8;');
		$result = mysql_query($sql, $conn);
		mysql_close($conn);

		return $result;
	}
}