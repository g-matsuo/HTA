<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        chdir($_SERVER['DOCUMENT_ROOT']);
        foreach(glob("./cgi-bin/lib/*.php") as $file){require_once($file);}

        //Initialize
        $rdb = init_PHP_Process();

        //user
        if($_POST["token"] != "null"){
            $user = $rdb->actSelect('SELECT * FROM table_customer WHERE token = "' . $_POST["token"] . '"');
            $user = $user[0];
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
                        $result["data"] = getLoginUser("login", $rdb, $_POST["data"]);
                        $result["msg"] = "ログインしました。";
                    }else{
                        $result["flg"] = false;
                        $result["msg"] = ["failure" => "入力された「ログインID」と「パスワード」が一致しません。"];
                    }
                }
                break;
            case "hold" :

                break;
            case "checkLoginUser" :
                if(!isset($user)){
                    $result["flg"] = false;
                }
                break;
            default :
        }

        print json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
?>