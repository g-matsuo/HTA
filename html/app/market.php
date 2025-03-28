<div class="market_filed">
    <div class="app_title">相場検索</div>
    
    <div class="app_msg">
        <div>相場検索を行う機能です。</div>
        <div>条件を設定して「検索」を押してください。</div>
    </div>
    
    <div class="app_body" style="overflow: hidden;">
        <div class="animation-spinner-box">
            <div class="spinner-text animation-blink">読み込み中です。</div>
            <div class="spinner-box"></div>
        </div>
        <div class="market_search_elements responce_flex">
            <div id="market_search_category" class="market_search_content">
                <div class="market_caption">カテゴリ</div>
                <select id="search_category">
                    <option category_name_english="null" category_code="null">カテゴリを選択してください。</option>
                </select>
            </div>

            <div id="market_search_brand" class="market_search_content">
                <div class="market_caption">ブランド</div>
                <input id="search_brand" type="text">
                <div class="app_matches_box"></div>
            </div>

            <div id="market_search_model_number" class="market_search_content">
                <div class="market_caption">型番</div>
                <input id="search_model_number" type="text">
            </div>
        </div>

        <div class="button market_search_button" type="app" value="market_search_graph">検索</div>
        <div class="search_content"></div>
    </div>

    <div class="app_button_group no_responce_flex">
        <div class="success_button app_buttons button" type="app" value="hide">CLOSE</div>
    </div>
</div>
<script>
    $(()=>{
        console.log("market_initalize");

        //Set Scroll Range
        resize_scroll_filed($(".app_body"), $(".market_filed"), [$(".app_title"), $(".app_button_group"), $(".app_msg")]);

        //Set Category List
        dicMaster["category"].forEach(dics => {
            $("#search_category").append('<option category_name_english="' + dics["category_name_english"] + '" category_code="' + dics["category_code"] + '">' + dics["category_name"] + '</option');
        })

        //Set Category and Brand
        if(!dicMaster["CategoryBrand"]){
            setTimeout(()=>{
                dicMaster["CategoryBrand"] = Ajax({flg:"get_market_downlist"});
            },200);
        }

        //Load Animation OFF
        setTimeout(()=>{
            $('.animation-spinner-box').fadeOut();
        },500);
    })

    $(window).off("resize").on("resize", ()=>{
        resize_scroll_filed($(".app_body"), $(".market_filed"), [$(".app_title"), $(".app_button_group"), $(".app_msg")]);
    })

    $('#search_brand').off("input").on('input', ()=>{
        let text = $('#search_brand').val();
        let category_code = $('#search_category option:selected').attr("category_code");
        
        $('.app_matches_box').empty();

        if(category_code != "null" && text != ""){
            let matches = dicMaster.CategoryBrand[category_code].filter(item => {
                return (
                    (item.brand_name && item.brand_name.includes(text)) ||
                    (item.brand_name_english && item.brand_name_english.includes(text))
                );

            });

            if(matches.length == 0){
                $('.app_matches_box').fadeOut();

            }else if(matches.length == 1){
                $('#search_brand').val("");
                $('#search_brand').val(matches[0].brand_name + "(" + matches[0].brand_name_english + ")");
                $('#search_brand').attr("brand_code", matches[0].brand_code);
                $('.app_matches_box').fadeOut();
                
            }else{
                matches.forEach(item => {
                    $('.app_matches_box').append('<div class="app_matches_item button" type="app" value="select_matches_item" brand_code="' + item.brand_code + '">' + item.brand_name + '<br>(' + item.brand_name_english + ')</div>');
                });

                $('.app_matches_box').fadeIn();
            }
        }
    });
</script>
