$(function(){
   $('#content').load('home.php');  
   
   $('.navigation').each(function(){
      $(this).click(function(){
         var link = $(this).attr('href');
         $('#content').load(link);
         return false;
      });
   });   
});

function show_detail(tes){
   $('#content').load('detail.php?tes='+tes);
}

function show_petunjuk(tes){
   $('#content').load('petunjuk.php?tes='+tes);   
}

function show_tes(tes){
   $('#content').load('tes.php?tes='+tes);
   return false;
}

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