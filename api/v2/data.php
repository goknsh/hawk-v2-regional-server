<?php
    $dourl = $_GET["url"] . '?'. md5(uniqid(rand(), true)) . '=' . md5(uniqid(rand(), true));
    error_reporting(0);
    header("Access-Control-Allow-Origin: *");
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $dourl);
    curl_setopt($c, CURLOPT_HEADER, TRUE);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($c, CURLOPT_CERTINFO, TRUE);
    curl_setopt($c, CURLOPT_TIMEOUT, 25);
    curl_setopt($c, CURLOPT_COOKIESESSION, TRUE);
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($c, CURLOPT_MAXREDIRS, 15);
    
    curl_setopt($c, CURLOPT_FRESH_CONNECT, 1);
    curl_setopt($c, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($c, CURLOPT_DNS_CACHE_TIMEOUT, 0);
    curl_setopt($c, CURLOPT_SSL_SESSIONID_CACHE, 0);
    curl_setopt($c, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Hawk Bot/1.0; Report Abuse at: +https://usehawk.ga/bot)');
    
    if (!curl_exec($c) | (int)curl_getinfo($c)['http_code'] === 408) {
        $return = array(
            "1" => "timeout",
            "2" => (curl_getinfo($c)['namelookup_time']+curl_getinfo($c)['connect_time']+curl_getinfo($c)['appconnect']+curl_getinfo($c)['pretransfer_time']+curl_getinfo($c)['redirect_time']+curl_getinfo($c)['starttransfer_time'])*1000,
            "3" => curl_getinfo($c)['http_code'],
            "4" => curl_getinfo($c)['speed_download'] * 8 / 1024 / 1024,
            "5" => curl_getinfo($c)['size_download'],
            "6" => curl_getinfo($c)['namelookup_time']*1000,
            "7" => curl_getinfo($c)['connect_time']*1000,
            "8" => addslashes(explode("CN = ", curl_getinfo($c)['certinfo'][1]['Subject'])[1]),
            "9" => curl_getinfo($c)['certinfo'][0]['Expire date']
        );
        curl_close($c);
        echo json_encode($return);
    } else {
        $code = (int)curl_getinfo($c)['http_code'];
        if ($code < 399) {
            $return = array(
                "1" => "up",
                "2" => (curl_getinfo($c)['namelookup_time']+curl_getinfo($c)['connect_time']+curl_getinfo($c)['appconnect']+curl_getinfo($c)['pretransfer_time']+curl_getinfo($c)['redirect_time']+curl_getinfo($c)['starttransfer_time'])*1000,
                "3" => curl_getinfo($c)['http_code'],
                "4" => curl_getinfo($c)['speed_download'] * 8 / 1024 / 1024,
                "5" => curl_getinfo($c)['size_download'],
                "6" => curl_getinfo($c)['namelookup_time']*1000,
                "7" => curl_getinfo($c)['connect_time']*1000,
                "8" => addslashes(explode("CN = ", curl_getinfo($c)['certinfo'][1]['Subject'])[1]),
                "9" => curl_getinfo($c)['certinfo'][0]['Expire date'],
            );
            curl_close($c);
            echo json_encode($return);
        } else {
            $return = array(
                "1" => "down",
                "2" => (curl_getinfo($c)['namelookup_time']+curl_getinfo($c)['connect_time']+curl_getinfo($c)['appconnect']+curl_getinfo($c)['pretransfer_time']+curl_getinfo($c)['redirect_time']+curl_getinfo($c)['starttransfer_time'])*1000,
                "3" => curl_getinfo($c)['http_code'],
                "4" => curl_getinfo($c)['speed_download'] * 8 / 1024 / 1024,
                "5" => curl_getinfo($c)['size_download'],
                "6" => curl_getinfo($c)['namelookup_time']*1000,
                "7" => curl_getinfo($c)['connect_time']*1000,
                "8" => addslashes(explode("CN = ", curl_getinfo($c)['certinfo'][1]['Subject'])[1]),
                "9" => curl_getinfo($c)['certinfo'][0]['Expire date'],
            );
            curl_close($c);
            echo json_encode($return);
        }
    }