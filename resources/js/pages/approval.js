//セレクトボックスが切り替わったら発動
$('#approvalSelecter').change(function() {
    console.log("変更されました。");
    this.form.submit();
});

var unapproved_table = $('.unapproved-table');
var approved_table = $('.approved-table');

approved_table.fadeToggle();

$('#change_button').click(function() {
    unapproved_table.fadeToggle();
    approved_table.fadeToggle('slow');
})

const FORM = $("#uplord-form"); // set form or other element here
const TYPES = ["input[type=text]"]; // set which elements get targeted by the focus
const FOCUS = $("#focus"); // focus element

// function for positioning the div
function position(e) {

    var id_name = "#" + e.attr('id');
    var input_offset = $(id_name).offset();
    var card_offset = $('.card').offset();

    var input_offset_top = input_offset.top;
    var input_offset_left = input_offset.left;
    var card_offset_top = card_offset.top;
    var card_offset_left = card_offset.left;

    var offset_top = input_offset_top - card_offset_top;
    var offset_left = input_offset_left - card_offset_left;

    // get position
    var props = {
        top: offset_top,
        left: offset_left,
        width: e.outerWidth(),
        height: e.outerHeight(),
        radius: parseInt(e.css("border-radius"))
    };
    
    // set position
    FOCUS.css({
        top: props.top,
        left: props.left,
        width: props.width,
        height: props.height,
        "border-radius": props.radius
    });
    
    FOCUS.fadeIn(200);
}

FORM.find(TYPES.join()).each(function(i) {
    // when clicking an input defined in TYPES
    $(this).focus(function() {
        el = $(this);

        // adapt size/position when resizing browser
        $(window).resize(function() {
        position(el);
        });

        position(el);
    });
});

FORM.on("focusout", function(e) {
    setTimeout(function() {
        if (!e.delegateTarget.contains(document.activeElement)) {
        FOCUS.fadeOut(200);
        }
    }, 0);
});