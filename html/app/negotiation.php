<div class="negotiation_filed">
    <div class="app_title">TtileCheck</div>
    
    <div class="app_msg">
        <div>test</div>
    </div>
    
    <div class="app_body">
        <div class="app_contents_group">
            test
        </div>

        <div class="app_button_group no_responce_flex">
            <div class="success_button app_buttons button" type="app" value="hide">CLOSE</div>
        </div>
    </div>
</div>
<script>
    $(()=>{
        resize_scroll_filed($(".app_body"), $(".negotiation_filed"), [$(".app_title"), $(".app_button_group"), $(".app_msg")]);
    })

    $(window).off("resize").on("resize", ()=>{
        resize_scroll_filed($(".app_body"), $(".negotiation_filed"), [$(".app_title"), $(".app_button_group"), $(".app_msg")]);
    })
</script>
