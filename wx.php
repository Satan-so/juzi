<?php

require_once('juzi.php');
define('TOKEN', 'juzi');
$wechatObj = new wechatCallbackapi();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $wechatObj->responseMsg();
} else {
    $wechatObj->valid();
}


class wechatCallbackapi {
	public function valid() {
        $echoStr = $_GET['echostr'];

        if ($this->checkSignature()) {
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg() {
		$postStr = $GLOBALS['HTTP_RAW_POST_DATA'];

        if (empty($postStr)) {
            echo '';
            exit;
        }

      	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);

        $juzi = new juzi();
        $res = $juzi->ack($keyword, $fromUsername);
        $time = time();

        if (is_array($res)) {
            $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <ArticleCount>1</ArticleCount>
                        <Articles>
                        <item>
                        <Title><![CDATA[%s]]></Title> 
                        <Description><![CDATA[%s]]></Description>
                        <PicUrl><![CDATA[$s]]></PicUrl>
                        <Url><![CDATA[$s]]></Url>
                        </item>
                        </Articles>
                        <FuncFlag>0</FuncFlag>
                        </xml>";
            
            $msgType = 'news';
            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $res['title'], $res['des'], $res['pic'], $res['url']);
        } else {
            $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";
            
            $msgType = 'text';
            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $res);
        }
        
        echo $resultStr;
    }
		
	private function checkSignature() {
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode($tmpArr);
		$tmpStr = sha1($tmpStr);
		
		if ($tmpStr == $signature) {
			return true;
		} else {
			return false;
		}
	}
}