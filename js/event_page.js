function click_Page_Events(e, data){
    console.log("Page:" + data["flg"]);
    let result;

    switch(data["flg"]){
        case "login":
            show_dialog(data["flg"], "php");
            break;

        case "hold":
            if(checkLoginUser()){
                show_app(data["flg"], "php");
            }else{
                show_info(
                    "Info",
                    ["ログインがされていません。","ログインフォームからログインをしてください。"],
                    {"type":"info", "value":"login_guidance"}
                )
            }
            break;

        case "market":
            show_app(data["flg"], "php");
            break;

        default:
            console.log("PageEvents:「" + e.target.attributes["value"].value + "」なんて処理されないよ！")
    }
}
