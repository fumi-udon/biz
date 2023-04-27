window.calcurry = function(){
    var  bouillons = $('#number').val();
    var r = bouillons * 0.155;
    var roux = Math.floor(r);

    var p = bouillons * 0.0036;
    var poudre = Math.floor(p);

    $("#roux").text(roux);
    $("#poud").text(poudre);

    // test
    $.ajaxSetup({
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
      });

        // formデータを取得
        var senddata = $('#form_adpage2').serialize();
        //alert(senddata);
        $.ajax({
          //POST通信
          type: "post",
          //データの送信先URLを指定
          url: "/reg_amounts",
          dataType: "json",
          data: senddata,     
        })
          //通信が成功したとき
          .then((res) => {
            // レスポンスをJSON データへ変換後オブジェクトへ変換
            var jsondatas = JSON.stringify(res);
            const obj = JSON.parse(jsondatas);
            // オブジェクト変換 End
            // 以降 obj 利用可能
            //console.log(obj["name"]);                
            for(var k in obj) {
                //kはキーが入る
                console.log(k);
                console.log(obj[k]);
            }

            // 処理
            // key=auth_flg 認証error(false) or 管理ページ遷移(true)
            // 
            var auth_flg = obj["auth_flg"];
            var ermsg = obj["ermsg"];
            //alert(ermsg);
          })
          //通信が失敗したとき
          .fail((error) => {
            console.log(error.statusText);
          });
}