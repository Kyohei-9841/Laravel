// window.onload = function(){  // ローディング画面をフェードアウトさせる
//     $(function() {
//         console.log("1")
//         $("#loading").fadeOut();
//     });
// }

$(function() {   //ロード中はコンテンツの高さをページの高さに合わせる
    $("#loader-text").text("読み込み中...")
    var h = $(window).height();
    $('#container').css('display','none');
    $('#loader-bg ,#loader').height(h).css('display','');
});

$(document).ready(function(){  //全ての読み込みが完了したら実行する
    $('#loader-bg').delay(450).fadeOut(400);
    $('#loader').delay(300).fadeOut(150);
    $('#container').css('display', '');
});

$(function(){  //10秒たったらロードを終わらせる
    setTimeout('stopload()',10000);
});