<div class="market_filed">
    <div class="app_title">相場検索</div>
    
    <div class="app_msg">
        <div>相場検索を行う機能です。</div>
        <div>条件を設定して「検索」を押してください。</div>
    </div>
    
    <div class="app_body">
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
                <div id="error_msg_category" class="error_msg" style="display:none;"></div>
            </div>

            <div id="market_search_brand" class="market_search_content">
                <div class="market_caption">ブランド</div>
                <div class="button market_brand_clear_button" type="app" value="market_brand_clear">クリア</div>
                <input id="search_brand" type="text" brand_code="null" autocomplete="off">
                <div class="app_matches_box"></div>
                <div id="error_msg_brand" class="error_msg" style="display:none;"></div>
            </div>
        </div>

        <div class="market_search_elements responce_flex">
            <div id="market_search_model_number" class="market_search_content">
                <!--
                <div class="market_search_model_number_mask position_center">
                    カテゴリを「時計」に選択した時のみ入力が可能です。
                </div>
                -->
                <div class="market_search_model_number_mask position_center">
                    未実装
                </div>
                <div class="market_caption">型番</div>
                <input id="search_model_number" type="text">
                <div id="error_msg_model_number" class="error_msg" style="display:none;"></div>
            </div>

            <div id="market_search_period" class="market_search_content">
                <div class="market_caption">期間</div>
                <select id="search_period">
                    <option value="1">過去１カ月</option>
                    <option value="3">過去３カ月</option>
                    <option value="6">過去６カ月</option>
                </select>
                <div id="error_msg_period" class="error_msg" style="display:none;"></div>
            </div>
        </div>
        <div class="button market_search_button" type="app" value="market_search_graph">検索</div>

        <div class="search_content no_responce_flex">
            <!-- lines -->
            <div class="market_small_scale_container">
                
            </div>
            <div class="market_large_scale_container">
                
            </div>

            <!-- lines -->
        </div>
    </div>

    <div class="app_button_group no_responce_flex">
        <div class="success_button app_buttons button" type="app" value="hide">CLOSE</div>
    </div>
</div>

<script>
    $(()=>{
        console.log("market_initalize");

        //Set Scale Element
        setScaleElement();

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

    $('#search_category').off("change").on("change", (e)=>{
        $('.app_matches_box').fadeOut(200, ()=>{
            $('.app_matches_box').empty();
            changeDownList();
        });

        if($(e.target).find('option:selected').attr('category_code') === "null"){
            $('#search_brand').val("").attr("brand_code", "null");
        }

        //if($(e.target).find('option:selected').attr('category_code') === "1"){
        //    $(".market_search_model_number_mask").fadeOut();
        //}else{
        //    $(".market_search_model_number_mask").fadeIn();
        //}
    })

    $('#search_brand').off("input").on('input', ()=>{
        $('.app_matches_box').attr("brand_code", "null");
        changeDownList();
    });

    function setScaleElement(){
        let number;
        const smallContainer = document.querySelector('.market_small_scale_container');
        const largeContainer = document.querySelector('.market_large_scale_container');

        //Small scale lines
        for (number = 1; number < 40; number++) {
            if(number < 10){
                const line = document.createElement('div');
                line.className = 'market_small_scale_line';
                line.style.bottom = `${number * 4}%`;
                smallContainer.appendChild(line);
            }else{
                const line = document.createElement('div');
                line.className = 'market_small_scale_line';
                line.style.bottom = `${42 + (number - 10) * 2}%`;
                smallContainer.appendChild(line);
            }
        }

        //Large scale lines
        for (number = 1; number <= 5; number++) {
            const line = document.createElement('div');
            line.className = 'market_large_scale_line';
            line.style.bottom = `${number * 20}%`;

            switch(number){
                case 1:
                    $(line).attr("line_price", "50000");
                    $(line).append('<div class="market_large_scale_plice_label">50,000</div>')
                    break;
                case 2:
                    $(line).attr("line_price", "100000");
                    $(line).append('<div class="market_large_scale_plice_label">100,000</div>')
                    break;
                case 3:
                    $(line).attr("line_price", "1000000");
                    $(line).append('<div class="market_large_scale_plice_label">1,000,000</div>')
                    break;
                case 4:
                    $(line).attr("line_price", "5000000");
                    $(line).append('<div class="market_large_scale_plice_label">5,000,000</div>')
                    break;
                case 5:
                    $(line).attr("line_price", "10000000");
                    $(line).append('<div class="market_large_scale_plice_label">10,000,000</div>')
                    break;
                default:
            }
            largeContainer.appendChild(line);
        }
    }

    function changeDownList(){
        let text = $('#search_brand').val();
        let category_code = $('#search_category option:selected').attr("category_code");

        if(category_code != "null" && text != ""){
            let matches = dicMaster.CategoryBrand[category_code].filter(item => {
                return (
                    (item.brand_name && item.brand_name.includes(text)) ||
                    (item.brand_name_english && item.brand_name_english.includes(text))
                );
            });

            if(matches.length){
                $('.app_matches_box').empty();
                matches.forEach(item => {
                    $('.app_matches_box').append('<div class="app_matches_item button" type="app" value="select_matches_item" brand_code="' + item.brand_code + '">' + item.brand_name + '<br>(' + item.brand_name_english + ')</div>');
                });
                $('.app_matches_box').fadeIn();

            }else{
                $('.app_matches_box').fadeOut(200, ()=>{
                    $('.app_matches_box').empty();
                });
            }

        }else{
            $('.app_matches_box').fadeOut(200, ()=>{
                $('.app_matches_box').empty();
            });
        }
    }
</script>
