$(function(){
// ramen 用レコード表示
  $("#rmn_open").on("click", function() {
    $("#rmn_record").css('display', 'inline-block');
  });
  $("#rmn_close").on("click", function() {
    $("#rmn_record").css('display', 'none');
  }); 
// udon 用レコード表示
  $("#udn_open").on("click", function() {
    $("#udn_record").css('display', 'inline-block');
  });
  $("#udn_close").on("click", function() {
    $("#udn_record").css('display', 'none');
  }); 
});