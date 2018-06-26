<?php
//header("Location: myapp2://goods:8888/goodsDetail?goodsId=10011002");

        $r=21;
        $cl = curl_init(); 
        $curl_opt = array(CURLOPT_URL, 'http://myapp2://goods:8888/goodsDetail?goodsId=10011002', 
        CURLOPT_RETURNTRANSFER, 1, 
        CURLOPT_TIMEOUT, 1,); 
        curl_setopt_array($cl, $curl_opt); 
        curl_exec($cl); 
        curl_close($cl);