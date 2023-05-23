$(function(){
// ramen 用レコード表示
  $("#note_open").on("click", function() {
    $("#note_record").css('display', 'inline-block');
  });
  $("#note_close").on("click", function() {
    $("#note_record").css('display', 'none');
  }); 
});