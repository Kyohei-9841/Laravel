var file = null; // 選択されるファイル
var blob = null; // 画像(BLOBデータ)
const THUMBNAIL_WIDTH = 1200; // 画像リサイズ後の横の長さの最大値
const THUMBNAIL_HEIGHT = 1200; // 画像リサイズ後の縦の長さの最大値

$(function() {
    // ファイルが選択されたら
    $('#pic').change(function() {

        // ファイルを取得
        file = $(this).prop('files')[0];
        // 選択されたファイルが画像かどうか判定
        if (file.type != 'image/jpeg' && file.type != 'image/png') {
            // 画像でない場合は終了
            file = null;
            blob = null;
            return;
        }
    
        // 画像をリサイズする
        var image = new Image();
        var reader = new FileReader();
        reader.onload = function(e) {
            var img_src = $('<img>').attr('src', reader.result);
            $('#images-disp').html(img_src);
    
            image.onload = function() {
            var width, height;
            if(image.width > image.height){
                // 横長の画像は横のサイズを指定値にあわせる
                var ratio = image.height/image.width;
                width = THUMBNAIL_WIDTH;
                height = THUMBNAIL_WIDTH * ratio;
            } else {
                // 縦長の画像は縦のサイズを指定値にあわせる
                var ratio = image.width/image.height;
                width = THUMBNAIL_HEIGHT * ratio;
                height = THUMBNAIL_HEIGHT;
            }
            // サムネ描画用canvasのサイズを上で算出した値に変更
            var canvas = $('#canvas')
                        .attr('width', width)
                        .attr('height', height);
            var ctx = canvas[0].getContext('2d');
            // canvasに既に描画されている画像をクリア
            ctx.clearRect(0,0,width,height);
            // canvasにサムネイルを描画
            ctx.drawImage(image,0,0,image.width,image.height,0,0,width,height);
    
            // canvasからbase64画像データを取得
            var base64 = canvas.get(0).toDataURL('image/jpeg');        
            // base64からBlobデータを作成
            var barr, bin, i, len;
            bin = atob(base64.split('base64,')[1]);
            len = bin.length;
            barr = new Uint8Array(len);
            i = 0;
            while (i < len) {
                barr[i] = bin.charCodeAt(i);
                i++;
            }
            blob = new Blob([barr], {type: 'image/jpeg'});
            console.log(blob);
            }
            image.src = e.target.result;
        }
        reader.readAsDataURL(file);
    });
});

window.onload = function() {
    document.getElementById("form-submit") != undefined ? document.getElementById("form-submit").onclick = async function() {
        try {
            func_loard_display("通信中...");
            // ファイルが指定されていなければ何も起こらない
            if(!file || !blob) {
                throw new Error('message : ファイル指定されてません');
            }
    
            var id = document.getElementById("id").value;
            var event_id = document.getElementById("event-id").value;
            var measurement = document.getElementById("measurement").value;
            var fish_species = document.getElementById("fish-species").value;
            var measurement_result = document.getElementById("measurement_result").value;
    
            var fd = new FormData();
            fd.append('id', id);
            fd.append('event_id', event_id);
            fd.append('measurement', measurement);
            fd.append('fish_species', fish_species);
            fd.append('measurement_result', measurement_result);
            fd.append('pic', blob);
    
            await fetch("/upload-submit", {
                method: "POST",
                headers: {
                    'X-CSRF-Token': document.getElementsByName("csrf-token").item(0).content
                },
                processData: false,
                contentType: false,
                body: fd
            })
            .then(response => {
                console.log("成功しました");
                func_loard_hide();
                location.href= "/event-entry/" + event_id;
            })
            .catch(error => {
                console.log(error);
                console.log("失敗しました");
                throw error;
            });    
        }catch(e) {
            func_loard_hide();
            alert(e);
        }
    } : null;
    
    document.getElementById("event-form-submit") != undefined ? document.getElementById("event-form-submit").onclick = async function() {
        try {
            func_loard_display("通信中...");
            // ファイルが指定されていなければ何も起こらない
            if(!file || !blob) {
                throw new Error('message : ファイル指定されてません');
            }

            var id = document.getElementById("id").value;
            var event_name = document.getElementById("event-name").value;
            var start_at = document.getElementById("start-at").value;
            var start_at_time = document.getElementById("start-at-time").value;
            var end_at = document.getElementById("end-at").value;
            var end_at_time = document.getElementById("end-at-time").value;
            var entry_fee_flg = document.getElementById("entry-fee-flg").value;
            var note = document.getElementById("note").value;
            var evaluation_criteria = document.getElementById("evaluation-criteria").value;
            var fish_species = document.getElementById("fish-species").value;

            var fd = new FormData();
            fd.append('id', id);
            fd.append('event_name', event_name);
            fd.append('start_at', start_at);
            fd.append('start_at_time', start_at_time);
            fd.append('end_at', end_at);
            fd.append('end_at_time', end_at_time);
            fd.append('entry_fee_flg', entry_fee_flg);
            fd.append('note', note);
            fd.append('evaluation_criteria', evaluation_criteria);
            fd.append('fish_species', fish_species);
            fd.append('pic', blob);
    
            await fetch("/event-submit", {
                method: "POST",
                headers: {
                    'X-CSRF-Token': document.getElementsByName("csrf-token").item(0).content
                },
                processData: false,
                contentType: false,
                body: fd
            })
            .then(response => {
                console.log("成功しました");
                func_loard_hide();
                location.href= "/event-management/" + id;
            })
            .catch(error => {
                console.log(error);
                console.log("失敗しました");
                throw error;
            });    
        }catch(e) {
            func_loard_hide();
            alert(e);
        }
    } : null;

    document.getElementById("profile-image-submit") != undefined ? document.getElementById("profile-image-submit").onclick = async function() {
        try {
            func_loard_display("通信中...");
            // ファイルが指定されていなければ何も起こらない
            if(!file || !blob) {
                throw new Error('message : ファイル指定されてません');
            }

            var id = document.getElementById("id").value;
            var image_id = document.getElementById("image_id").value;

            var fd = new FormData();
            fd.append('id', id);
            fd.append('image_id', image_id);
            fd.append('pic', blob);
    
            await fetch("/profile-update-image", {
                method: "POST",
                headers: {
                    'X-CSRF-Token': document.getElementsByName("csrf-token").item(0).content
                },
                processData: false,
                contentType: false,
                body: fd
            })
            .then(response => {
                console.log("成功しました");
                func_loard_hide();
                location.href= "/profile/" + id;
            })
            .catch(error => {
                console.log(error);
                console.log("失敗しました");
                throw error;
            });    
        }catch(e) {
            func_loard_hide();
            alert(e);
        }
    } : null;

    function func_loard_display(text) {
        try{
            document.getElementById("loader-text").innerHTML=text;
            var h = $(window).height();
            document.getElementById('container').style.display = 'none';
            var loader = document.getElementById('loader-bg', 'loader');
            loader.style.height = h;
            loader.style.display = '';
        } catch(e) {
            throw e;
        }
    }
    
    function func_loard_hide() {
        try{
            window.setTimeout(() => {
                document.getElementById('loader-bg').animate({
                    opacity: [0, 1]
                }, {
                    direction: 'reverse',
                    duration: 600
                })    
            }, 700);
            window.setTimeout(() => {
                document.getElementById('loader-bg', 'loader').animate({
                    opacity: [0, 1]
                }, {
                    direction: 'reverse',
                    duration: 150
                })
            }, 300);
            document.getElementById('container').style.display = '';
        } catch(e) {
            throw e;
        }
    }
}

