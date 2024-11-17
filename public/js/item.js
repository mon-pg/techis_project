window.onload = function(){

    $('#all').on('click',function() {
        $('input[name="check[]"]').prop('checked',this.checked);
      });
      
      $('input[name="check[]"]').on('click',function(){
        if($('.check :checked').length == $('.check input').length ) {
          $('#all').prop('checked',true);
        } else {
          $('#all').prop('checked',false);
        }
      });
      

}