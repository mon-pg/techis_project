$.ajaxSetup({
    headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),},
});

window.onload = function() {
//一括削除機能
    $('#deleteModal').on('shown.bs.modal', function (event) {   //選択一括削除ボタンが押されたらモーダルを開く

        const ids = $('.delete-check:checked').map(function(){  //チェックされたitemのIDを取得
            return $(this).val();
        }).get();
        console.log(ids);
        //console.log(ids.length);

        const modal = $(this);//モーダルを取得

        if(ids.length == 0) {  
            modal.find('.modal-body p.delete-message').hide();  
            modal.find('.modal-body p.none-message').html("選択された項目がありません。");
            modal.find('.modal-footer button').hide();
            return false;   //処理中断
        }else{
            modal.find('.modal-body p.none-message').hide();
            modal.find('.modal-body p.delete-message').show();
            modal.find('.modal-footer button').show();

            $('.btn-delete-confirm').off('click').on('click', function(){
                $.ajax({
                //POST通信
                type: "POST",
                //ここでデータの送信先URLを指定します。
                url: "/items/some/delete",
                dataType: "text",
                data: {
                    id: ids,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // これが必要
                  },
                })
                // 成功
                .done(function (results){
                    // alert('成功');
        
                    // 通信成功時の処理
                    console.log("results : " + results);        
                    window.location.href = "/items";     //削除後に画面を遷移

                })
                // 失敗
                .fail(function(jqXHR, textStatus, errorThrown){
                    alert('通信に失敗しました。');
                    console.log("ajax通信に失敗しました");
                    console.log("jqXHR          : " + jqXHR.status); // HTTPステータスが取得
                    console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラー
                    console.log("errorThrown    : " + errorThrown.message); // 例外情報
                    console.log("URL            : " + url);        
                });

            });
               
        }
    });


    // 背景クリックでモーダルが閉じないように設定
    $('#deleteModal').modal({
        backdrop: 'static',
        keyboard: false,
        show: false,
    });
    // 背景スクロールを強制的に有効化
    $('#deleteModal').on('show.bs.modal', function () {
        $('body').css('overflow', 'auto'); // スクロール許可
    });
    $('#deleteModal').on('hidden.bs.modal', function () {
        $('body').css('overflow', ''); // 元の状態に戻す
    });


//一括選択機能
    $('#all').on('click',function() {   //＜選択＞のチェックボックスを押したら、すべて選択
        $('input[name="delete-check[]"]').prop('checked',this.checked);
      });

      $('input[name="delete-check[]"]').on('click',function(){

        const checked = $('.delete-check:checked').length;  //チェックされた数
        const boxes = $('.delete-check').length;    //全体の数
  
        if(checked == boxes ) { //手動ですべてのボックスがチェックされたとき
          $('#all').prop('checked',true);   //＜選択＞のボックスにチェックを入れる
        } else {
          $('#all').prop('checked',false);
        }
      });
      



}
