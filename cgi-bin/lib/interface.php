<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        chdir($_SERVER['DOCUMENT_ROOT']);
        foreach(glob("./cgi-bin/lib/*.php") as $file){require_once($file);}

        //Initialize
        $rdb = init_PHP_Process();

        //user
        if($_POST["token"] != "null"){
            $user = $rdb->actSelect('SELECT * FROM table_customer WHERE token = ' . $_POST["token"]);
        }

        //mainData
        $result = ["flg" => true, "msg" => [], "data" => null];

        switch($_POST["flg"]){
            case "login" :
                $result = checkLoginValue($result, $_POST["data"]);

                if($result["flg"]){
                    $responce = getLoginUser("login", $rdb, $_POST["data"]);
                    
                    if($responce){
                        //cookie
                        $rdb->actSql('UPDATE hta.table_customer SET token="' . $_COOKIE["PRICING_DATA_ORIGINAL_COOKIE"] . '" WHERE  id=' . $responce[0]["id"]);

                        //data
                        $result["data"] = $responce;
                        $result["msg"] = "ログインしました。";
                    }else{
                        $result["msg"] = ["failure" => "入力された「ログインID」と「パスワード」が一致しません。"];
                        $result["flg"] = false;
                    }
                }
                break;

            case "hold" :

            default :
        }

        print json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
?>