$.ajaxSetup({
    headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),},
});

window.onload = function() {
//////////////
//一括選択機能
//////////////
    $('#all').on('click',function() {   //＜選択＞のチェックボックスを押したら、すべて選択
        $('input[name="user-check[]"]').prop('checked',this.checked);
      });

      $('input[name="user-check[]"]').on('click',function(){

        const checked = $('.user-check:checked').length;  //チェックされた数
        const boxes = $('.user-check').length;    //全体の数
  
        if(checked == boxes ) { //手動ですべてのボックスがチェックされたとき
          $('#all').prop('checked',true);   //＜選択＞のボックスにチェックを入れる
        } else {
          $('#all').prop('checked',false);
        }
      });
      
       
}
