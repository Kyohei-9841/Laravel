window.onload = () => {
    var test_val = $('#testtesttest');
    try {
        console.log("カメラ処理の入り口！！とおるか確認");
        const video  = $("#camera");
        const canvas = $("#picture");
        const se     = $('#se');
        test_val.val("1");
        console.log("1");

        /** カメラ設定 */
        const constraints = {
            audio: false,
            // video: true
            video: {
                width: 300,
                height: 200,
                // facingMode: "user"   // フロントカメラを利用する
                facingMode: { exact: "environment" }  // リアカメラを利用する場合
            }
        };
        test_val.val("2");
        console.log("2");

        var test = navigator.mediaDevices;

        test_val.val("2-1");
        console.log("2-1");

        /**
         * カメラを<video>と同期
         */
        test.getUserMedia(constraints)
        .then( (stream) => {
            test_val.val("3");
            console.log("3");

            // document.getElementById('video').srcObject = stream;
            video.srcObject = stream;
            video.onloadedmetadata = (e) => {
                video.play();
            };
        })
        .catch( (err) => {
            console.log("エラーが発生した！！" + err.name + ": " + err.message);
            test_val.val("エラーが発生した！！" + err.name + ": " + err.message);
        });
        test_val.val("4");
        console.log("4");

        /**
         * シャッターボタン
        */
        $("#shutter").addEventListener("click", () => {
            const ctx = canvas.getContext("2d");
        
            // 演出的な目的で一度映像を止めてSEを再生する
            video.pause();  // 映像を停止
            se.play();      // シャッター音
            setTimeout( () => {
                video.play();    // 0.5秒後にカメラ再開
            }, 500);
      
            // canvasに画像を貼り付ける
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        });    
    } catch(e) {
        test_val.val("大元のエラー" + e);
    }
};

var takePicture = $("#take-picture");
takePicture.onchange = function (event) {
    // 撮影された写真または選択された画像への参照を取得
    var files = event.target.files,
        file;
    if (files && files.length > 0) {
        file = files[0];
        console.log("テストテスト");
        console.log(file.lastModifiedDate);
    }
};