$(function(){
    // Ajax
    // welcome.blade Administrateurリンク押下アクション
    $("#validate_admin").on("click",function(){
        $.ajaxSetup({
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
          });

            // formデータを取得
            var senddata = $('#form_adpage').serialize();
            $.ajax({
              //POST通信
              type: "post",
              //データの送信先URLを指定
              url: "/admin_validate",
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
                if (auth_flg == true) {                    
                    $('#view_ermsg').css("background-color","yellow").text(ermsg).fadeOut(20000);
                    window.location.href = "/admin_top_menu";
                  } else {
                    console.log('false ですね');
                    // エラーメッセージ表示 view_ermsg
                    console.log(obj["ermsg"]);
                     $('#view_ermsg').css("background-color","yellow").text(ermsg).fadeOut(50000);                
                  }

              })
              //通信が失敗したとき
              .fail((error) => {
                console.log(error.statusText);
              });
    });//validate_admin

}); //end