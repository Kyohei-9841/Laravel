//セレクトボックスが切り替わったら発動
$('#userSelecter').change(function() {
    console.log("変更されました。");
    this.form.submit();
});
