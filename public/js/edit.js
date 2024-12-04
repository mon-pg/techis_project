$.ajaxSetup({
    headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),},
});

window.onload = function() {
//削除機能
    $('#deleteModal').on('shown.bs.modal', function (event) {   //削除ボタンが押されたら

        const button = $(event.relatedTarget);//モーダルを呼び出すときに使われたボタンを取得
        const url = button.data('url');//data-urlの値を取得
        const id = button.data('id');
        const modal = $(this);//モーダルを取得

        //formタグのaction属性にurlのデータ渡す
        modal.find('form').attr('action',url);
              
        
    });


    // 背景クリックでモーダルが閉じないように設定
    $('#deleteModal').modal({
        backdrop: 'static',
        keyboard: false,
        show: false,
    });
    






}
