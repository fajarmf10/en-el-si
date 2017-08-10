var save_method, table;

$(function(){
   table = $('.table').DataTable({
      "processing" : true,
      "ajax" : {
         "url" : "ajax/ajax_peserta.php?action=table_data",
         "type" : "POST"
      }
   });
});

function form_add(){
   save_method = "add";
   $('#id_tim').removeAttr('readonly');
   $('#modal_peserta').modal('show');
   $('#modal_peserta form')[0].reset();
   $('.modal-title').text('Tambah Peserta');
}
	
function form_edit(id){
   save_method = "edit";
   $('#modal_peserta').modal('show');
   $('#modal_peserta form')[0].reset();
   $.ajax({
      url : "ajax/ajax_peserta.php?action=form_data&id="+id,
      type : "GET",
      dataType : "JSON",
      success : function(data){
         $('.modal-title').text('Edit Peserta');
         $('#id_tim').val(data.id_tim).attr('readonly',true);
         $('#nama').val(data.nama);
         $('#edisi').val(data.id_edisi);
      },
      error : function(){
         alert("Tidak dapat menampilkan data!");
      }
   });
}

function save_data(){
   if(save_method == "add") 
      url = "ajax/ajax_peserta.php?action=insert";
   else url = "ajax/ajax_peserta.php?action=update";
   $.ajax({
      url : url,
      type : "POST",
      data : $('#modal_peserta form').serialize(),
      success : function(data){
         if(data=="ok"){
            $('#modal_peserta').modal('hide');
            table.ajax.reload();
         }else{
            alert(data);
            $('#id_tim').focus();
         }
      },
      error : function(){
         alert("Tidak dapat menyimpan data!");
      }			
   });
   return false;
}

function delete_data(id){
   if(confirm("Apakah yakin data akan dihapus?")){
      $.ajax({
         url : "ajax/ajax_peserta.php?action=delete&id="+id,
         type : "GET",
         success : function(data){
            table.ajax.reload();
         },
         error : function(){
            alert("Tidak dapat menghapus data!");
         }
      });
   }
}

function form_import(){
   $('#modal_import').modal('show');
   $('.modal-title').text('Import Excel');
   $('#modal_import form')[0].reset();
}

function import_data(){
   var formdata = new FormData();      
   var file = $('#file')[0].files[0];
   formdata.append('file', file);
   $.each($('#modal_import form').serializeArray(), function(a, b){
      formdata.append(b.name, b.value);
   });
   $.ajax({
      url: 'ajax/ajax_peserta.php?action=import',
      data: formdata,
      processData: false,
      contentType: false,
      type: 'POST',
      success: function(data) {
         if(data=="ok"){
            $('#modal_import').modal('hide');
            table.ajax.reload();
         }else{
            alert(data);
         }
      },
      error: function(data){
         alert('Tidak dapat mengimport data!');
      }
   });
   return false;
}
