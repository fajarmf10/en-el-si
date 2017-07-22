var save_method, table;

$(function(){
   table = $('.table').DataTable({
      "processing" : true,
      "ajax" : {
         "url" : "ajax/ajax_tes.php?action=table_data",
         "type" : "POST"
      }
   });

   $('.datepicker').datepicker({
      format: 'yyyy-mm-dd', 
      autoclose: true
   });
});

function form_add(){
   save_method = "add";
   $('#modal_tes').modal('show');
   $('#modal_tes form')[0].reset();
   $('.modal-title').text('Tambah Tes');
}
	
function form_edit(id){
   save_method = "edit";
   $('#modal_tes form')[0].reset();
   $.ajax({
      url : "ajax/ajax_tes.php?action=form_data&id="+id,
      type : "GET",
      dataType : "JSON",
      success : function(data){
         $('#modal_tes').modal('show');
         $('.modal-title').text('Edit Tes');
			
         $('#id').val(data.id_tes);
         $('#judul').val(data.judul);
         $('#tanggal').val(data.tanggal);
         $('#waktu').val(data.waktu);
         $('#jml_soal').val(data.jml_soal);
         $('#acak_soal').val(data.acak_soal);
         $('#acak_jawaban').val(data.acak_jawaban);
      },
      error : function(){
         alert("Tidak dapat menampilkan data!");
      }
   });
}

function save_data(){
   if(save_method == "add") url = "ajax/ajax_tes.php?action=insert";
   else url = "ajax/ajax_tes.php?action=update";
   $.ajax({
      url : url,
      type : "POST",
      data : $('#modal_tes form').serialize(),
      success : function(data){
         $('#modal_tes').modal('hide');
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
        url : "ajax/ajax_tes.php?action=delete&id="+id,
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
