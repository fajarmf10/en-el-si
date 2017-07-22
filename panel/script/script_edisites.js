var save_method, table;

$(function(){
   table = $('.table').DataTable({
      "processing" : true,
      "ajax" : {
         "url" : "ajax/ajax_edisites.php?action=table_data",
         "type" : "POST"
      }
   });
});

function form_edit(id){
   $.ajax({
      url : "ajax/ajax_edisites.php?action=form_data&id="+id,
      type : "GET",
      dataType : "JSON",
      success : function(data){
         $('#modal_edisites form')[0].reset();
         $('#modal_edisites').modal('show');
         $('.modal-title').text('Manajemen Edisi dan Tes');
			
         $('#id').val(id);
         var edisi = data.edisi.split(',');
         for(i=0; i<edisi.length; i++){
            $('[value='+edisi[i]+']').attr('checked', true);
         }
      },
      error : function(){
         alert('Tidak dapat menampilkan data');
      }
   });
	
   $('#edisi input').attr('checked', false);		
}

function save_data(){
   url = "ajax/ajax_edisites.php?action=update";
   $.ajax({
      url : url,
      type : "POST",
      data : $('#modal_edisites form').serialize(),
      success : function(data){
         $('#modal_edisites').modal('hide');
         table.ajax.reload();
      },
      error : function(){
         alert("Tidak dapat menyimpan data!");
      }			
   });
   return false;
}