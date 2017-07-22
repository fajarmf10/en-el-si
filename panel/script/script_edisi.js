var save_method, table;

$(function(){
   table = $('.table').DataTable({
      "processing" : true,
      "ajax" : {
         "url" : "ajax/ajax_edisi.php?action=table_data",
         "type" : "POST"
      }
   });
});

function form_add(){
   save_method = "add";
   $('#modal_edisi').modal('show');
   $('#modal_edisi form')[0].reset();
   $('.modal-title').text('Tambah Edisi');
}
	
function form_edit(id){
   save_method = "edit";
   $('#modal_edisi form')[0].reset();
   $.ajax({
      url : "ajax/ajax_edisi.php?action=form_data&id="+id,
      type : "GET",
      dataType : "JSON",
      success : function(data){
         $('#modal_edisi').modal('show');
         $('.modal-title').text('Edit Edisi');
			
         $('#id').val(data.id_edisi);
         $('#edisi').val(data.edisi);
      },
      error : function(){
         alert("Tidak dapat menampilkan data!");
      }
   });
}

function save_data(){
   if(save_method == "add")
      url = "ajax/ajax_edisi.php?action=insert";
   else url = "ajax/ajax_edisi.php?action=update";
   
   $.ajax({
      url : url,
      type : "POST",
      data : $('#modal_edisi form').serialize(),
      success : function(data){
         $('#modal_edisi').modal('hide');
         table.ajax.reload();
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
         url : "ajax/ajax_edisi.php?action=delete&id="+id,
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
