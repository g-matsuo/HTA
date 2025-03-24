function click_App_Events(e, data){
    console.log("App:" + data["flg"]);
    let result;

    switch(data["flg"]){
        case "hide":
            hide_app();
            break;
        default:
            console.log("PageEvents:「" + e.target.attributes["value"].value + "」なんて処理されないよ！")
    }
}
