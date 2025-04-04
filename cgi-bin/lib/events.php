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

    function checkMarketSearchValues($result, $data){
        if($data["category_code"] !== "null" && $data["category_code"] !== "1" && $data["category_code"] !== "2" && $data["category_code"] !== "3"){
            $result["msg"]["category"]  = "選択外が入力されました。";
            $result["flg"] = false;
        }

        if($data["period"] !== "1" && $data["period"] !== "3" && $data["period"] !== "6"){
            $result["msg"]["period"]  = "選択外が入力されました。";
            $result["flg"] = false;
        }

        return $result;
    }

    function createSearchWhere($data){
        $where = "";

        $where .= "dh.updated_at >= DATE_SUB(NOW(), INTERVAL " . $data["period"] . " MONTH) AND ";

        if($data["category_code"] !== "null"){
            $where .= "dh.category_code = " . $data["category_code"] . " AND ";
        }

        if($data["brand_code"] !== "null"){
            $where .= "dh.brand_code = " . $data["brand_code"] . " AND ";
        }

        if($data["model_number"] !== "" && $data["category_code"] === "1"){
            $where .= 'dh.ref LIKE "%' . $data["model_number"] . '%" AND ';
        }

        $where = rtrim($where, " AND ");

        return $where;
    }
?>