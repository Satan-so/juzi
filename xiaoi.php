<?php

$xiaoi = new xiaoi();
echo $xiaoi->ack('你好吗');

class xiaoi {
    public function ack($key) {
        $post_data = array (
            'requestContent=' . $key
        );
        $post_data = implode ( '&', $post_data );
        $url = 'http://nlp.xiaoi.com/robot/demo/wap/wap-demo.action';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        curl_close($ch);
        list($header, $body) = explode("\r\n\r\n", $content);
        preg_match_all("/set\-cookie:([^\r\n]*)/i", $header, $matches);
        $cookie = $matches[1];
        var_dump($matches);
                           
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        $result = curl_exec ( $ch );
        //var_dump($result);
                           
        $preg = '/<\/span>(.*)<\/p>/iUs';
        preg_match_all ( $preg, $result, $match );
        $response_msg = $match [0] [0];
        $preg = "/<\/?[^>]+>/i";
        $response_msg = preg_replace ( $preg, '', $response_msg );
        // if ("hello,how are you" == $response_msg || "how do you do" == $response_msg) {
        //     $response_msg = "小i机器人欢迎您，作者主页地址：50vip.com。小i机器人不断学习中，欢迎各种调戏.../:,@-D"; // 欢迎语
        // }
        $response_msg = trim ( $response_msg );
        return $response_msg;
    }
}