<?php
    function getMaster($rdb){
        $result = [];

        $result["brand"] = $rdb->actSelect('
            SELECT * FROM brand_masters
        ');

        $result["category"] = $rdb->actSelect('
            SELECT * FROM category_masters
        ');

        return $result;
    }

    function getLoginUser($flg, $rdb, $data = null){
        $columns = "customer_display_code, company_name, customer_token";

        switch($flg){
            case "login":
                return $rdb->actSelect('
                    SELECT ' . $columns . ' FROM customer_masters
                    WHERE customer_display_code = "' . $data["login_id"] . '"
                    AND   password = "' . md5($data["login_password"]) . '"
                ');

            case "cookie":
                return $rdb->actSelect('
                    SELECT ' . $columns . ' FROM customer_masters
                    WHERE customer_token = "' . $_COOKIE["PRICING_DATA_ORIGINAL_COOKIE"] . '"
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