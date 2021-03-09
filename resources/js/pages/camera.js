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
    $('#form-submit').click(function(){

        console.log("ここは１");
  
        // ファイルが指定されていなければ何も起こらない
        if(!file || !blob) {
            return;
        }
        console.log("ここは２");

        var id = $('#id').val();
        var position = $('#position').val();
        var fish_species = $('#fish_species').val();
        var size = $('#size').val();

        var name, fd = new FormData();
        fd.append('id', id);
        fd.append('position', position);
        fd.append('fish_species', fish_species);
        fd.append('size', size);
        fd.append('pic', blob);

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
                location.href= "/fishing-results?id=" + id;
            },
            error: function(){
                //通信が失敗した場合の処理
                console.log("送信失敗");
            }
        });
    });
});