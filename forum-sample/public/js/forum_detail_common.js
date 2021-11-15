$(function(){
    $("#trashbox").click(function(){
        if(window.confirm("本当に削除してもよろしいですか？")) {
            $("#delete_submit").submit();
        } else {
            alert("キャンセルしました");
        }
    });

    $("#submit_heart").one("click", function(){
        $("#good_submit").submit();
    });

    const margins = $("[class*='margin-left']")
    for(let i = 0; i < margins.length; i++) {
        const className = margins[i].className;
        //クラス名をsplitする
        const classes = className.split(" ");
        //クラス名の中でmargin-leftで始まるものだけを選ぶ
        for(let j = 0; j < classes.length; j++) {
            if(classes[j].startsWith("margin-left")) {
                //クラス名から階層を抽出する
                let level = Number(classes[j].replace("margin-left",""));
                //1階層あたり30pxのマージンを左に設ける
                level *= 30;
                margins[i].style.marginLeft = `${level}px`;
            }
        }
    }

    if($(".alert-danger").length) {
        const position = $(".alert-danger:first").offset().top - 200;
        $('.main-content').animate({scrollTop:position}, 400, 'swing');
    }
});
