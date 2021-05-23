$(function() {
    var file = null; // 選択されるファイル
    var blob = null; // 画像(BLOBデータ)
    const THUMBNAIL_WIDTH = 1200; // 画像リサイズ後の横の長さの最大値
    const THUMBNAIL_HEIGHT = 1200; // 画像リサイズ後の縦の長さの最大値
  
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
  
    // アップロード開始ボタンがクリックされたら
    $('#form-submit').click(async function(){
        try {
            func_loard_display("通信中...");
    
            // ファイルが指定されていなければ何も起こらない
            if(!file || !blob) {
                throw new Error('message : ファイル指定されてません');
            }

            var id = $('#id').val();
            var event_id = $('#event-id').val();
            // var position = $('#position').val();
            var fish_species = $('#fish-species').val();
            var size = $('#size').val();

            var name, fd = new FormData();
            fd.append('id', id);
            fd.append('event_id', event_id);
            // fd.append('position', position);
            fd.append('fish_species', fish_species);
            fd.append('size', size);
            fd.append('pic', blob);
            // fd.append('latitude', latitude);
            // fd.append('longitude', longitude);
    
            // fd.append('_token', "{{ csrf_token() }}");
            $.ajaxSetup({ async: false });
            $.ajax({
                url: "/upload-submit", // 送信先
                type: 'POST',
                data: fd,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data, textStatus, jqXHR){
                    //通信が成功した場合の処理
                    console.log("送信成功");
                    func_loard_hide();    
                    location.href= "/event-entry/" + event_id;
                },
                error: function(error){
                    //通信が失敗した場合の処理
                    func_loard_hide();
                    alert("message : 通信に失敗しました");
                    throw new Error('message : 通信に失敗しました');
                }
            });        

            // var wOptions = {
            //     "enableHighAccuracy": true,                       // true : 高精度
            //     "timeout": 10000,                                 // タイムアウト : ミリ秒
            //     "maximumAge": 0,                                  // データをキャッシュ時間 : ミリ秒
            // };

            // // 現在地を取得
            // await navigator.geolocation.getCurrentPosition(
            //     // 取得成功した場合
            //     async function(position) {
            //         alert("取得OK");

            //         var latitude = position.coords.latitude;
            //         var longitude = position.coords.longitude;
            //         console.log("緯度:"+position.coords.latitude+",経度"+position.coords.longitude);
            //         alert("緯度:"+position.coords.latitude+",経度"+position.coords.longitude);

            //         var id = $('#id').val();
            //         var event_id = $('#event-id').val();
            //         // var position = $('#position').val();
            //         var fish_species = $('#fish-species').val();
            //         var size = $('#size').val();
    
            //         var name, fd = new FormData();
            //         fd.append('id', id);
            //         fd.append('event_id', event_id);
            //         // fd.append('position', position);
            //         fd.append('fish_species', fish_species);
            //         fd.append('size', size);
            //         fd.append('pic', blob);
            //         fd.append('latitude', latitude);
            //         fd.append('longitude', longitude);
            
            //         // fd.append('_token', "{{ csrf_token() }}");
            //         $.ajaxSetup({ async: false });
            //         $.ajax({
            //             url: "/upload-submit", // 送信先
            //             type: 'POST',
            //             data: fd,
            //             processData: false,
            //             contentType: false,
            //             headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //             },
            //             success: function(data, textStatus, jqXHR){
            //                 //通信が成功した場合の処理
            //                 console.log("送信成功");
            //                 location.href= "/event-entry/" + event_id;
            //             },
            //             error: function(error){
            //                 //通信が失敗した場合の処理
            //                 console.log(error);
            //                 console.log("送信失敗");
    
            //             }
            //         });        
            //     },
            //     // 取得失敗した場合
            //     async function(error) {
            //         switch(error.code) {
            //         case 1: //PERMISSION_DENIED
            //             alert("位置情報の利用が許可されていません");

            //             console.log("位置情報の利用が許可されていません");
            //             break;
            //         case 2: //POSITION_UNAVAILABLE
            //             alert("現在位置が取得できませんでした");

            //             console.log("現在位置が取得できませんでした");
            //             break;
            //         case 3: //TIMEOUT
            //             alert("タイムアウトになりました");

            //             console.log("タイムアウトになりました");
            //             break;
            //         default:
            //             alert("その他のエラー(エラーコード:"+error.code+")");

            //             console.log("その他のエラー(エラーコード:"+error.code+")");
            //             break;
            //         }
            //     },
            //     wOptions
            // );    
        } catch(e) {
            func_loard_hide();
            alert(e);
        }
    });

    // イベント登録のサブミット
    $('#event-form-submit').click(function(){
        try {

            func_loard_display("通信中...");

            // ファイルが指定されていなければ何も起こらない
            if(!file || !blob) {
                throw new Error('message : ファイル指定されてません');
            }
    
            var id = $('#id').val();
            var event_name = $('#event-name').val();
            var start_at = $('#start-at').val();
            var start_at_time = $('#start-at-time').val();
            var end_at = $('#end-at').val();
            var end_at_time = $('#end-at-time').val();
            var entry_fee_flg = $('#entry-fee-flg').val();
            var note = $('#note').val();
            var evaluation_criteria = $('#evaluation-criteria').val();
            var fish_species = $('#fish-species').val();
    
            var name, fd = new FormData();
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
    
            // fd.append('_token', "{{ csrf_token() }}");
            $.ajaxSetup({ async: false });
            $.ajax({
                url: "/event-submit", // 送信先
                type: 'POST',
                data: fd,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data, textStatus, jqXHR){
                    //通信が成功した場合の処理
                    console.log("送信成功");
                    func_loard_hide();    
                    location.href= "/event-management/" + id;
                },
                error: function(){
                    //通信が失敗した場合の処理
                    func_loard_hide();
                    alert("message : 通信に失敗しました");
                    throw new Error('message : 通信に失敗しました');
                }
            });    
        } catch(e) {
            func_loard_hide();
            alert(e);
        }
    });

    $('#profile-image-submit').click(function(){
        try {

            func_loard_display("通信中...");

            // ファイルが指定されていなければ何も起こらない
            if(!file || !blob) {
                throw new Error('message : ファイル指定されてません');
            }

            var id = $('#id').val();
            var image_id = $('#image_id').val();

            var name, fd = new FormData();
            fd.append('id', id);
            fd.append('image_id', image_id);
            fd.append('pic', blob);

            // fd.append('_token', "{{ csrf_token() }}");
            $.ajaxSetup({ async: false });
            $.ajax({
                url: "/profile-update-image", // 送信先
                type: 'POST',
                data: fd,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data, textStatus, jqXHR){
                    //通信が成功した場合の処理
                    console.log("送信成功");
                    func_loard_hide();    
                    location.href= "/profile/" + id;
                },
                error: function(){
                    //通信が失敗した場合の処理
                    func_loard_hide();
                    alert("message : 通信に失敗しました");
                    throw new Error('message : 通信に失敗しました');
                }
            });

        } catch(e) {
            func_loard_hide();
            alert(e);
        }
    });

    function func_loard_display(text) {
        try{
            $("#loader-text").text(text)
            var h = $(window).height();
            $('#container').css('display','none');
            $('#loader-bg ,#loader').height(h).css('display','');
        } catch(e) {
            throw e;
        }
    }

    function func_loard_hide() {
        try{
            $('#loader-bg').delay(700).fadeOut(600);
            $('#loader').delay(300).fadeOut(150);
            $('#container').css('display', '');
        } catch(e) {
            throw e;
        }
    }
});