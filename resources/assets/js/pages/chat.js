$(document).ready(function() {

    // if (location.pathname == "/chat") {
    //     const screanHeight = $(window).height();
    //     const hedderHeight = $("#follow-header").height();
    //     const container = $("#container");
    //     const top = $("#top");
    //     const msgfld = $("#msgfld");
    //     const form = $("#form");

    //     const containerHeight = screanHeight - hedderHeight;

    //     const topHeight = containerHeight * 0.05;
    //     const msgfldHeight = containerHeight * 0.75;
    //     const formHeight = containerHeight * 0.2;
    //     container.css('height', containerHeight);
    //     top.css('height', topHeight);
    //     msgfld.css('height', msgfldHeight);
    //     form.css('height', formHeight);
    // }

    console.log(location.pathname);

    console.log($("#msgfld").height());
    scrollTo(0, $("#msgfld").height());
    $.ajaxSetup({
        headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")}
    });

    $("#submit").click(function() {
        const url = "/chat-send";
        $.ajax({
            url: url,
            data: {
                hostUserId: $("#hostUserId").val(),
                eventId: $("#eventId").val(),
                message: $("#message").val(),
            },
            method: "POST"
        });

        $("#message").val('');
        $("#message").css('height', '2.5em');

        return false;
    });

    console.log(window.Echo);

    window.Echo.channel("channelName").listen("PusherEvent", e => {

        let message = e.chatsModel.message;
        const sendUserId = e.chatsModel.send_user_id;
        const sendUserName = e.chatsModel.send_user_name;
        const userImageId = e.chatsModel.user_image_id;
        const createdAt = new Date(e.chatsModel.created_at);
        const userId = $("#userId").val();

        let imagePath = "";
        if (userImageId == undefined) {
            imagePath = "../images/images_4.png";
        } else {
            imagePath = "../storage/upload/3/chat_2_10.jpg"
        }

        let divAppend = '';

        if (sendUserId == userId) {
            const divMsg = '<div style="width:100%; padding:10px; background-color:lightblue; border-radius: 20px;">' + message.replace(/\n/g, '<br>') + '</div>';
            const divTime = '<div class="text-right font-size-5 font-color-gray" style="width:100%;">' + createdAt.toLocaleString() + '</div>';
            const div = '<div style="width:80%; margin: 0px 10px 0px auto">' + divMsg + divTime + '</div>';
            divAppend = '<div class="mt-3">' + div + '</div>';
        } else {
            const img = '<img class="round-frame-chat" src="' + imagePath + '">';
            const span = '<span>' + sendUserName + '</span>';
            const divMsg = '<div style="width:100%; padding:10px; background-color: grey; border-radius: 20px; color: white">' + message.replace(/\n/g, '<br>') + '</div>';
            const divTime = '<div class="font-size-5 font-color-gray" style="width:100%;">' + createdAt.toLocaleString() + '</div>';
            const div = '<div style="width:80%; margin: 0px auto 0px 0px">' + divMsg + divTime + '</div>';
            divAppend = '<div class="mt-3"><div style="margin: 0px auto 0px 10px">' + img + span + div + '</div></div>';
        }

        $('#board').append(divAppend);

        scrollTo(0, $("#msgfld").height());

    });
});
  
$(function(){
    $('textarea.auto-resize')
        .on('change keyup keydown paste cut', function(){
        if ($(this).outerHeight() > this.scrollHeight){
            $(this).height(1)
        }
        while ($(this).outerHeight() < this.scrollHeight){
            $(this).height($(this).height() + 1)
        }
    });
});