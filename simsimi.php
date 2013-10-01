<?php

class simsimi {
    public function ack($keyword) {
        $url = "http://www.simsimi.com/talk.htm?lc=ch";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        curl_close($ch);
        list($header, $body) = explode("\r\n\r\n", $content);
        preg_match("/set\-cookie:([^\r\n]*)/i", $header, $matches);
        $cookie = $matches[1];

        $urll = 'http://www.simsimi.com/func/req?msg=' . $keyword . '&lc=ch';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urll);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_REFERER, "http://www.simsimi.com/talk.htm?lc=ch");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        $content = curl_exec($ch);
        curl_close($ch);
           
        $json = json_decode($content, true);
        if (!empty($json) && $json['result'] == 100) {
            return $json['response'];
        }

        $json = json_decode($json, 1);
        if (isset($json['response'])) {
            $reply = $json['response'];
        }

        return $reply;
    }
 }