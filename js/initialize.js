function initalize_process(){
    //Element
    initialize_load_element();
    console.info("complate load element");

    //Parameter
    intilize_set_Param();
    console.info("complate set parameter");

    //Frontui
    initilize_set_FrontUi();
    console.info("complate set indexs");

    //Master
    initialize_get_master();
    console.info("complate set master data");

}

function initialize_load_element(){
    $("header").load("./html/frame/header.php");
    $("content").load("./html/frame/top.php");
    //$("footer").load("./frame/footer.php");
}

function intilize_set_Param(){
    dicParam["event_flg"] = true;
}

function initilize_set_FrontUi(){
    $(".front_ui").each((index, element)=>{
        dicFrontui[$(element).attr("id")] = {};
        dicFrontui[$(element).attr("id")]["index"] = $(element).css("z-index");
        dicFrontui[$(element).attr("id")]["element"] = $(element);
    });
}

function initialize_get_master(){
    dicMaster = Ajax({"flg" : "master"})
}