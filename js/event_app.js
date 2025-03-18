function click_Page_Events(e, data){
    console.log("App:" + data["flg"]);
    let result;

    switch(data["flg"]){
        case "hold":
            break;

        default:
            console.log("PageEvents:「" + e.target.attributes["value"].value + "」なんて処理されないよ！")
    }
}
