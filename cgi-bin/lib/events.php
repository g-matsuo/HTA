<?php
    function getLoginUser($flg, $rdb, $data = null){
        $columns = "name, token";
        
        switch($flg){
            case "login":
                return $rdb->actSelect('
                    SELECT ' . $columns . ' FROM table_customer
                    WHERE customer_no = "' . $data["login_id"] . '"
                    AND   password = "' . md5($data["login_password"]) . '"
                ');

            case "cookie":
                return $rdb->actSelect('
                    SELECT ' . $columns . ' FROM table_customer
                    WHERE token = "' . $_COOKIE["PRICING_DATA_ORIGINAL_COOKIE"] . '"
                ');
        }
    }

    function checkLoginValue($result, $data){
        if($data["login_id"] == ""){
            $result["msg"]["login_id"] = "ログインIDを入力してください。";
            $result["flg"] = false;
        }

        if($data["login_password"] == ""){
            $result["msg"]["login_password"] = "パスワードを入力してください。";
            $result["flg"] = false;
        }

        return $result;
    }
?>