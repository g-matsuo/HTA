<?php
    foreach(glob("./cgi-bin/lib/*.php") as $file){require_once($file);}

    //Initialize
    $rdb = init_PHP_Process();

    //login_check
    $user = getLoginUser("cookie", $rdb);
?>

<html lang="ja">
    <head>
        <title>HTA</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

        <!-- link -->
        <?php foreach(glob("./css/*.css") as $file){echo('        <link rel="stylesheet" href="' . $file . '" media="all">');} ?>

        <!-- script -->
        <?php foreach(glob("./js/*.js") as $file){echo('        <script src="' . $file . '"></script>');} ?>
    </head>

    <body>
        <div id="mask_black" class="front_ui"></div>
        <div id="dialog"     class="front_ui"></div>
        <div id="app"        class="front_ui"></div>
        <div id="info"       class="front_ui"></div>

        <header class="frame_element"></header>
        <content></content>
    </body>

    <script>
        var dicParam = {};
        var dicFrontui = {};
        <?php echo 'var dicUser = JSON.parse(`' . json_encode($user[0], JSON_UNESCAPED_UNICODE) . '`);' . "\n"; ?>
        
        $(()=>{
            initalize_process();
        })

        $(document).on('click', '.button', (e)=>{
            click_Events(e);

			if (dicParam["event_flg"]){
                $(".button").removeClass("select_button");
				$(e.target).addClass("select_button");
				dicParam["event_flg"] = false;

				setTimeout(() => {
					$(e.target).removeClass("select_button");
					dicParam["event_flg"] = true;
				}, 350);

			}else{
				console.log("wait:" + e.currentTarget.attributes["value"].value);
			}
        });

    </script>
</html>