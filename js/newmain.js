function selesai_tes(tes){
   $.ajax({
      url: "ajax_tes.php?action=selesai_tes",
      type: "POST",
      data: "tes="+tes,
      success: function(data){
         if(data=="ok"){
            $('#modal-selesai').modal('hide');
            $('#modal-selesai').on('hidden.bs.modal', function(){
            window.location = '?content=home';
            });	
         }else{
            alert(data);
         }
      },
      error: function(){
         alert('Tidak dapat memproses nilai!');
      }
   });
   return false;
}