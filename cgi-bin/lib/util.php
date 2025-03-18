<?php
    function init_PHP_Process(){
        //Mysql
        $master = json_decode(file_get_contents("./cgi-bin/master/master.json"), true);
        $rdb = new RDB($master["dev"]["host"], $master["dev"]["user"], $master["dev"]["password"], $master["dev"]["schema"]);
        //$rdb = new RDB($master["prod"]["host"], $master["prod"]["user"], $master["prod"]["password"], $master["prod"]["schema"]);

        //Cookie
        actCookieProcess($rdb);

        return $rdb;
    }

    function putLogFormat($msg){
        return "[" . date("Y-m-d H:i:s") . "] " . $msg . PHP_EOL;
    }

    function putErrorLog($msg, $path){
        file_put_contents($path . date("Ymd") . '_error.log', putLogFormat($msg), FILE_APPEND);
    }

    function generateRundomString($length) {
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $rand = random_int(0, 2);

            if ($rand === 0) {
                $randomString .= chr(random_int(48, 57));
            } elseif ($rand === 1) {
                $randomString .= chr(random_int(97, 122));
            } else {
                $randomString .= chr(random_int(65, 90));
            }
        }

        return $randomString;
    }

    function actCookieProcess($rdb){
        $cokkie_key = "PRICING_DATA_ORIGINAL_COOKIE";

        if(isset($_COOKIE[$cokkie_key])){
            $cookieUsers = $rdb->actSelect('SELECT token FROM table_customer WHERE token = "' . $_COOKIE[$cokkie_key] . '"');
            if(count($cookieUsers) > 1){
                $cookie_val = generateRundomString(32);
            }else{
                $cookie_val = $_COOKIE[$cokkie_key];
            }
            
        }else{
            $dicTokens = $rdb->actSelectAndKeySorting('SELECT token FROM table_customer', "token");
            do {
                $cookie_val = generateRundomString(32);
            } while (isset($dicTokens[$cookie_val]));
        }

        //cliant terminal set & update
        setcookie($cokkie_key, $cookie_val, time() + 3600, "/");

        //global
        $_COOKIE[$cokkie_key] = $cookie_val;
    }
?>
