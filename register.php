<?php

// simple coding by Iddant ID
date_default_timezone_set('Asia/Jakarta');
error_reporting(0);
set_time_limit(0);
ini_set('memory_limit', '-1');
ini_set('output_buffering', 0);
ini_set('request_order', 'GP');
ini_set('variables_order', 'EGPCS');
ini_set('max_execution_time', '-1');


// get file wallet
$file = file_get_contents("wallet.txt");
$explode = explode("\n", $file);
foreach ($explode as $wallet) {

    // getting fake data
    $fake = array();
    $fake[] = "Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4854.140 Safari/537.36";
    $fake[] = "Host: api.namefake.com";
    $fake[] = "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9";
    $fake[] = "referer: https://namefake.com/";

    $url = curl_init();
    curl_setopt($url, CURLOPT_URL, "https://api.namefake.com/");
    curl_setopt($url, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($url, CURLOPT_HTTPHEADER, $fake);
    curl_setopt($url, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($url, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($url, CURLOPT_SSL_VERIFYHOST, 0);
    $result1 = curl_exec($url);
    $json = json_decode($result1, true);
    $ua = $json['useragent'];

    // prossesiing signup in wallet
    $body = "address=" . $wallet . "&code=7crX";
    $header = array(
        'Host: www.gemstone.ink',
        'User-Agent: ' . $ua . '',
        'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
        'Accept: */*',
        'X-Requested-With: XMLHttpRequest',
        'Origin: https://www.gemstone.ink',
        'Referer: https://www.gemstone.ink/?code=7crX',
        'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7,ru;q=0.6,mt;q=0.5',
        'Cookie: var_think=en; think_var=id-id'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.gemstone.ink/index/ajax/submit");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    $response = curl_exec($ch);
    $json = json_decode($response, true);
    $id = $json['data']['id'];
    $msg = $json['data']['address'];
    $rew = $json['data']['money'];
    $rev = $json['data']['invitation_link'];
    
    echo " \e[34mINFO\e[0m: ID Account     : \e[92m{$id}\e[0m\n";
    echo " \e[34mINFO\e[0m: Wallet         : \e[92m{$msg}\e[0m\n";
    echo " \e[34mINFO\e[0m: Reward Money   : \e[92m{$rew}\e[0m GEM\n";
    echo " \e[34mINFO\e[0m: Invitation Link: \e[92m{$rev}\e[0m\n\n";
    
// file save with txt
    $file = 'gemstone.txt';
    $person = "{$wallet}|{$rew}\n";
    file_put_contents($file, $person, FILE_APPEND | LOCK_EX);
    
}
