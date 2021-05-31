$(function() {
    $('#prefectures').change(function() {
        console.log("これきてる？");
        var prefectures = $(this).val();
        var address = $('#address-div');

        if (prefectures == 0) {
            console.log("これきてる１？");

            address.css('display','none');
        } else {
            console.log("これきてる２？");

            address.css('display','');
        }
    })

    $('#selected_id').change(function() {
        console.log("プロフィールのイベント変更");
        var id = $('#pull_id').val();
        var event_id = $('#event_id').val();
        var back_btn_flg = $('#back_btn_flg').val();
        var selected_id = $('#selected_id').val();

        var name, fd = new FormData();
        fd.append('event_id', event_id);
        fd.append('back_btn_flg', back_btn_flg);
        fd.append('selected_id', selected_id);

        // fd.append('_token', "{{ csrf_token() }}");
        $.ajaxSetup({ async: false });
        $.ajax({
            url: "/profile/" + id, // 送信先
            type: 'GET',
            data: fd,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data, textStatus, jqXHR){
                //通信が成功した場合の処理
                console.log("送信成功");
                location.href= "/profile/" + id + "?selected_id=" + selected_id + "&back_btn_flg=" + back_btn_flg;
            },
            error: function(){
                //通信が失敗した場合の処理
                console.log("送信失敗");
            }
        });
    })

    $('#event-id').change(function() {
        console.log("これきてる？");
        let event_datas = $('#event-lists').data();
        console.log(event_datas);
        if (event_datas === undefined) {
            return;
        }
        let event_lists = event_datas['name'];
        var select_event_id = $(this).val();

        var event_data = $.grep(event_lists,
            function(elem, index) {
              return (elem.id == select_event_id);
            }
        );
        console.log(event_data[0]['fish_species']);
        
        $('#fish-species').val(event_data[0]['fish_species']);

        var measurement_data = event_data[0]['measurement'];
        var measurement = "";
        if (measurement_data == 1) {
            measurement = "★サイズ";
        } else if (measurement_data == 2) {
            measurement = "★匹数";
        } else if (measurement_data == 3) {
            measurement = "★重さ";
        }

        $("#measurement-label").text(measurement);
    })
});