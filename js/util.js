function Ajax(ajaxData, sync=false){
    return $.ajax({
        url: "./cgi-bin/lib/interface.php",
        type: "POST",
        dataType: "json",
        async: sync,
        data: ajaxData
    }).responseJSON;
}

function resize_scroll_filed(target, filed_element, elements){
    let total_height = 0;
    elements.forEach(element => {
        total_height += element.outerHeight(true)
    });

    let scroll_filed_size = filed_element.outerHeight(true) - total_height;
    $(target).height(scroll_filed_size);
}

function dialog_show(){
    $(".black_mask").fadeIn();
    $("#dialog").fadeIn();
}

function dialog_close(){
    $(".black_mask").fadeOut();
    $("#dialog").fadeOut();
}

function setInputData(elements){
    let rtn = {};
    elements.each(function(index, element) {
        let key = $(element).attr("key");
        rtn[key] = $(element).val();
    });

    return rtn;
}