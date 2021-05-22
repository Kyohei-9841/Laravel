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
        var admin_flg = $('#admin_flg').val();
        var back_btn_flg = $('#back_btn_flg').val();
        var selected_id = $('#selected_id').val();

        var name, fd = new FormData();
        fd.append('event_id', event_id);
        fd.append('admin_flg', admin_flg);
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
                location.href= "/profile/" + id + "?event_id=" + event_id + "&selected_id=" + selected_id + "&admin_flg=" + admin_flg + "&back_btn_flg=" + back_btn_flg;
            },
            error: function(){
                //通信が失敗した場合の処理
                console.log("送信失敗");
            }
        });
    })
});