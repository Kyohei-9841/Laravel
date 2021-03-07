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