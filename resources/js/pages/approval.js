//セレクトボックスが切り替わったら発動
$('#approvalSelecter').change(function() {
    console.log("変更されました。");
    this.form.submit();
});
