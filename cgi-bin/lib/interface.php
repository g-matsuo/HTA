<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        chdir($_SERVER['DOCUMENT_ROOT']);
        foreach(glob("./cgi-bin/lib/*.php") as $file){require_once($file);}

        //Initialize
        $rdb = init_PHP_Process();

        //user
        if($_POST["token"] != "null"){
            $user = $rdb->actSelect('SELECT * FROM customer_masters WHERE customer_token = "' . $_POST["token"] . '"');
            $user = $user[0];
        }

        //mainData
        $result = ["flg" => true, "msg" => [], "data" => null];

        switch($_POST["flg"]){
            case "master" :
                $result = getMaster($rdb);
                break;

            case "login" :
                $result = checkLoginValue($result, $_POST["data"]);

                if($result["flg"]){
                    $responce = getLoginUser("login", $rdb, $_POST["data"]);
                    
                    if($responce){
                        //cookie
                        $rdb->actSql('UPDATE customer_masters SET customer_token="' . $_COOKIE["PRICING_DATA_ORIGINAL_COOKIE"] . '" WHERE  customer_display_code=' . $responce[0]["customer_display_code"]);

                        //data
                        $result["data"] = getLoginUser("login", $rdb, $_POST["data"]);
                        $result["msg"] = "ログインしました。";
                    }else{
                        $result["flg"] = false;
                        $result["msg"] = ["failure" => "入力された「ログインID」と「パスワード」が一致しません。"];
                    }
                }
                break;
            case "market_search_graph" :
                $result = checkMarketSearchValues($result, $_POST["data"]);

                if($result["flg"]){
                    $where = createSearchWhere($_POST["data"]);

                    $result["data"] = $rdb->actSelect('
                        SELECT
                            dh.detail_code,
                            dh.market_code,
                            dh.box_code,
                            dh.item_information,
                            dh.brand_code,
                            dh.category_code,
                            dh.options,
                            dh.before_price,
                            dh.price,
                            mi.market_name
                        FROM      detail_historys AS dh
                        LEFT JOIN market_informations AS mi ON dh.market_code = mi.market_code
                        WHERE ' . $where .'
                        AND   dh.price != 0
                        AND   dh.hide_web_flag = 0
                        ORDER BY dh.price DESC
                    ');
                }

                break;
            case "get_market_downlist":
                $result = $rdb->actSelectAndKeySorting('
                    SELECT DISTINCT
                        dh.category_code,
                        dh.brand_code,
                        cm.category_name,
                        cm.category_name_english,
                        bm.brand_name,
                        bm.brand_name_english
                    FROM      detail_historys  AS dh
                    LEFT JOIN category_masters AS cm ON dh.category_code = cm.category_code
                    LEFT JOIN brand_masters    AS bm ON dh.brand_code = bm.brand_code;
                ', "category_code");
                break;

            case "check_login_user" :
                if(!isset($user)){
                    $result["flg"] = false;
                }
                break;
            default :
        }

        print json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
?>