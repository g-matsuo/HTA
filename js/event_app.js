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
                setMarketGraph(responce["data"]);
                console.log("true");
            }else{
                setErrorMsg(responce["msg"]);
                console.log("false");
            }
            break;
        
        case "market_brand_clear":
            $("#search_brand").val("").attr("brand_code", "null");
            $('.app_matches_box').fadeOut(200, ()=>{
                $('.app_matches_box').empty();
            });
            break;

        default:
            console.log("PageEvents:「" + e.target.attributes["value"].value + "」なんて処理されないよ！")
    }
}

function setMarketGraph(arr){
    let scaleLines = [];

    $(".market_large_scale_line").each((index, element) => {
        scaleLines.push({
            price: parseInt($(element).attr("line_price")),
            bottom: parseFloat($(element).css("bottom")) // 例: "60%" → 60
        });
    });

    scaleLines.sort((a, b) => a.price - b.price);

    arr.forEach((data, index) => {
        const value = parseInt(data.price);
        const bottom = getBottomByPrice(value, scaleLines);

        const bar = document.createElement('div');
        bar.className = 'graph_element';
        bar.style.right = `${(index * 35) + 10}px`;
        bar.style.height = `${bottom}%`;

        document.querySelector('.search_content').appendChild(bar);
    });
}

function getBottomByPrice(price, scaleLines) {
    if (price <= scaleLines[0].price) return scaleLines[0].bottom;

    for (let i = 1; i < scaleLines.length; i++) {
        const lower = scaleLines[i - 1];
        const upper = scaleLines[i];

        if (price <= upper.price) {
            const ratio = (price - lower.price) / (upper.price - lower.price);
            return lower.bottom + (upper.bottom - lower.bottom) * ratio; // 線形補間
        }
    }

    // 最大値超えた場合は最上段
    return scaleLines[scaleLines.length - 1].bottom;
}
