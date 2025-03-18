function click_Events(e){
    console.log("Default:" + $(e.target).attr("type") + "/" + $(e.target).attr("value"));

    let data = {};
    data["flg"] = $(e.target).attr("value");
    data["token"] = dicUser == null ? "null" : dicUser["token"];

    switch(e.target.attributes["type"].value){
        case "page":
            click_Page_Events(e, data);
            break;
            
        case "dialog":
            click_Dialog_Events(e, data);
            break;
            
        case "app":
            click_App_Events(e, data);
            break;

        default:
            console.log("DefaultEvents:「" + e.target.attributes["value"].value + "」なんて処理されないよ！")
    }
}

function hide_dialog(){
    $('#dialog').fadeOut(200);
    $('#mask_black').fadeOut(200);
}

function hide_all(){
    for(let id in dicFrontui){
        dicFrontui[id].fadeOut(200);
    }
}

function show_dialog(value, type){
    $('#dialog').load('/html/dialog/'+ value + '.' + type, () => {
        changeFrontUi("dialog");
        $("#mask_black").fadeIn(200);
        $("#dialog").fadeIn(200);
    });
}

function show_app(value, type){
    $('#app').load('/html/app/'+ value + '.' + type, () => {
        changeFrontUi("app");
        $("#mask_black").fadeIn(200);
        $("#app").fadeIn(200);
    });
}

function show_info(title, msgs, attrs){
    $('#dialog').load('/html/dialog/info.php', () => {
        //title
        $(".info_title").text(title);

        //msg
        $.each(msgs, (index, msg)=>{
            $('.info_msg').append('<p>' + msg + '</p>')
        })

        //button
        $.each(attrs, (key, value)=>{
            $('.info_buttons').attr(key, value);
        });

        changeFrontUi("dialog");
        $("#mask_black").fadeIn(200);
        viewTopDownMove($("#dialog"));
    });
}

function changeFrontUi(target_id){
    $('.menu_button').css({"z-index":"10"});

    for(let id in dicFrontui){
        dicFrontui[target_id]["element"].css({"z-index":dicFrontui[id]["index"]});
    }
    
    $(dicFrontui[target_id]["element"][0]).css({"z-index":"90"});
}

function viewTopDownMove(target){
    $("#all_mask_block").fadeIn(200);
    target.css({"left":"50%", "top":"30%", "opacity":"0", "display":"block"});
    target.animate({left:'50%', top:'50%', opacity:"1"}, 200);
}

function viewMenuMove(position_value){
    let menu_btn = $(".menu_button");

    if(position_value=="-100%"){
        menu_btn[0].attributes["status"].value = "false";
        menu_btn.removeClass('active');
    }else{
        $('#all_mask_block').fadeIn(200);
        menu_btn[0].attributes["status"].value = "true";
        menu_btn.addClass('active');

    }
    $('#menu').animate({right: position_value}, 200);
}

function setErrorMsg(arrError){
    $(".error_msg").animate({ opacity: 0 }, 100,()=>{
        for(let id in arrError){
            $("#error_msg_" + id).text(arrError[id]);
            $("#error_msg_" + id).fadeIn();
            $("#error_msg_" + id).animate({ opacity: 1 }, 300);
        }
        
    });
}