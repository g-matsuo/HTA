function click_Page_Events(e, data){
    console.log("Page:" + data["flg"]);
    let result;

    switch(data["flg"]){
        case "login":
            show_dialog(data["flg"], "php");
            break;

        case "hold":
            show_app(data["flg"], "php");
            break;

        case "market":
            break;

        default:
            console.log("PageEvents:「" + e.target.attributes["value"].value + "」なんて処理されないよ！")
    }
}
