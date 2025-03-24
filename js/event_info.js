function click_Info_Events(e, data){
    console.log("Page:" + data["flg"]);
    let result;

    switch(data["flg"]){
        case "login_guidance":
            $("#dialog").fadeOut(200, ()=>{
                show_dialog("login", "php");
            });
            break;

        case "market":
            break;

        default:
            console.log("PageEvents:「" + e.target.attributes["value"].value + "」なんて処理されないよ！")
    }
}
