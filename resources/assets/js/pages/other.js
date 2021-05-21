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

});