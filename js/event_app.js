function click_App_Events(e, data){
    console.log("App:" + data["flg"]);
    let result;

    switch(data["flg"]){
        case "hide":
            hide_app();
            break;

        case "select_matches_item" :
            $('#search_brand').val("");
            $('#search_brand').val($(e.target).text());
            $('#search_brand').attr("brand_code", $(e.target).attr("brand_code"));
            $('.app_matches_box').fadeOut();
            break;

        case "market_search_graph":
            let set = {};

            $(".error_msg").css("display","none");
            
            set["category_code"] = $('#search_category option:selected').attr('category_code');
            set["brand_code"] = $('#search_brand').attr('brand_code');
            set["model_number"] = $('#search_model_number').val().trim();
            set["period"] = $('#search_period option:selected').attr('value');

            responce = Ajax({
                "flg" : data["flg"],
                "data" : set
            })

            if(responce["flg"]){
                console.log("true");
            }else{
                setErrorMsg(responce["msg"]);
                console.log("false");
            }
            break;
        
        case "market_brand_clear":
            $("#search_brand").val("").attr("brand_code", "null");
            break;

        default:
            console.log("PageEvents:「" + e.target.attributes["value"].value + "」なんて処理されないよ！")
    }
}
