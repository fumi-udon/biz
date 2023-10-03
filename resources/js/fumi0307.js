$(function(){
  // emporter_recent pageのボタン押下
  $("#btn_emp").on("click",function(){
    console.log('emporter_recent ボタン押下');    
  });

  // Jesser Page 売上登録 envoyer ボタン
  $("#btn_jsser_env").on("click",function(){
    console.log('[Page: Jesser finance] envoyer ボタン押下');    
  });

  // Jesser Page 初期金額アップデート表示
  $("#up_montan_open").on("click", function() {
    $("#elem_update_montant").css('display', 'inline-block');
  });

  // 登録データ表示非表示
  $("#note_open").on("click", function() {
    $("#note_record").css('display', 'inline-block');
  });
  $("#note_close").on("click", function() {
    $("#note_record").css('display', 'none');
  }); 

  // データ表示非表示
  $("#btn_password_record").on("click", function() {
    // id="password_record"の値を取得
    var passwordValue = $("#password_record").val();
    
    if (passwordValue === '1227' || passwordValue === '0117') {
        // 一致する場合はアラートを表示
        $("#note_record").css('display', 'inline-block');
    }else{
      alert('Error: password');
    }
  });


});