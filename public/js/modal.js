window.onload = function() {
//一括削除機能
    $('#deleteModal').on('shown.bs.modal', function (event) {   //選択一括削除ボタンが押されたら

        const ids = $('.delete-check:checked').map(function(){  //チェックされたitemのIDを取得
            return $(this).val();
        }).get();
        //console.log(ids);
        //console.log(ids.length);

        const modal = $(this);//モーダルを取得

        if(ids.length == 0) {    
            modal.find('.modal-body p.message').eq(0).html("選択された項目がありません。");
            modal.find('.modal-footer button').hide();
            return false;   //処理中断
        }else{
            modal.find('.modal-body p.message').eq(0).html("選択した項目を本当に削除しますか？");
            modal.find('.modal-footer button').show();

            $('.btn-delete-confirm').on('click', function(){
                $.ajaxSetup({
                    headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),},
                });
                $.ajax({
                //POST通信
                type: "POST",
                //ここでデータの送信先URLを指定します。
                url: "/items/some_delete",
                dataType: "text",
                data: {
                    id: ids,
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
                    alert('削除に失敗しました。');
                    console.log("ajax通信に失敗しました");
                    console.log("jqXHR          : " + jqXHR.status); // HTTPステータスが取得
                    console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラー
                    console.log("errorThrown    : " + errorThrown.message); // 例外情報
                    console.log("URL            : " + url);        
                });

            })
               
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

}
