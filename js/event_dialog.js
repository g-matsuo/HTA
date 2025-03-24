async function click_Dialog_Events(e, data){
    console.log("Dialog:" + data["flg"]);
    let result;

    switch(data["flg"]){
        case "hide":
            hide_dialog();
            break;

        case "login":
            data["data"] = setInputData($(".input_data"));
            result = Ajax(data, false);

            if(result["flg"]){
                dicUser = result["data"];
                $("#dialog").fadeOut(200,()=>{
                    show_info("ログイン通知",[result["msg"]],{"type":"dialog", "value":"hide"});
                })
            }else{
                setErrorMsg(result["msg"]);
                setTimeout(() => {
                    window.dispatchEvent(new Event("resize"));
                }, 150);
            }
            break;

        case "hold":

            break;

        default:
            console.log("DialogEvents:「" + e.target.attributes["value"].value + "」なんて処理されないよ！")
    }
}
