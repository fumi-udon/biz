$(function(){
  // チェックボックスの要素を取得します
  var fritures = $('#fritures');
  // チェックボックスの状態が変更されたときの処理を定義します
  fritures.on('change', function() {
    if (fritures.prop('checked')) {
      fritures.attr('data-bs-target', '#frituresModal');   
    } else {
      $('#frituresModal').hide();
    }
  });

  // climatiseursModalLabel
  // チェックボックスの要素を取得します
  var climatiseurs = $('#climatiseurs');
  // チェックボックスの状態が変更されたときの処理を定義します
  climatiseurs.on('change', function() {
    if (climatiseurs.prop('checked')) {
      climatiseurs.attr('data-bs-target', '#climatiseursModal');   
    } else {
      $('#climatiseursModal').hide();
    }
  });

  // foodModal
  // チェックボックスの要素を取得します
  var food = $('#food');
  // チェックボックスの状態が変更されたときの処理を定義します
  food.on('change', function() {
    if (food.prop('checked')) {
      food.attr('data-bs-target', '#foodModal');   
    } else {
      $('#foodModal').hide();
    }
  });

});