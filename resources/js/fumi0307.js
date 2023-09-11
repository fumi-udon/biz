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

});