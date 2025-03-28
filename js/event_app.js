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

            set["category_code"] = $('#search_category option:selected').attr('category_code');
            set["brand_code"] = $('#search_brand option:selected').attr('brand_code');

            Ajax({
                "flg" : data["flg"],
                "data" : set
            })

            break;
        default:
            console.log("PageEvents:「" + e.target.attributes["value"].value + "」なんて処理されないよ！")
    }
}
