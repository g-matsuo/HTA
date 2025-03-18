<div class="dialog_default dialog_login_filed">
    <div class="dialog_title">
        ログインフォーム
    </div>

    <div class="dialog_msg">
        <div>ご連絡させて頂いた「Login ID」、及び「パスワード」を入力してください。</div>
        <div id="error_msg_failure" class="error_msg"></div>
    </div>

    <div class="dialog_body position_center">
        <div class="dialog_contents_group">
            <div class="login_input_element">
                <div class="dialog_caption">Login ID</div>
                <input class="input_data" key="login_id" type="text">
                <div id="error_msg_login_id" class="error_msg"></div>
            </div>

            <div class="login_input_element">
                <div class="dialog_caption">Password</div>
                <input class="input_data" key="login_password" type="text">
                <div id="error_msg_login_password" class="error_msg"></div>
            </div>
        </div>
    </div>

    <div class="dialog_button_group no_responce_flex">
        <div class="cancel_button dialog_buttons button" type="dialog" value="hide">キャンセル</div>
        <div class="success_button dialog_buttons button" type="dialog" value="login">ログイン</div>
    </div>
</div>
<script>
    $(()=>{
        resize_scroll_filed($(".dialog_body"), $(".dialog_login_filed"), [$(".dialog_title"), $(".dialog_button_group"), $(".dialog_msg")]);
    })

    $(window).off("resize").on("resize", ()=>{
        resize_scroll_filed($(".dialog_body"), $(".dialog_login_filed"), [$(".dialog_title"), $(".dialog_button_group"), $(".dialog_msg")]);
    })
</script>