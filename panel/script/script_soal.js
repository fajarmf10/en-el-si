var save_method, table;

$(function(){
   var tes = $('#id_tes').val();
   table = $('.table').DataTable({
      "processing" : true,
      "ajax" : {
         "url" : "ajax/ajax_soal.php?action=table_data&tes="+tes,
         "type" : "POST"
      }
   });   
   tinymce_config();
   tinymce_config_simple();
});

function form_add(){
   save_method = "add";
   $('#modal_soal').modal('show');
   $('#modal_soal form')[0].reset();
   $('.modal-title').text('Tambah Soal');
}

function form_edit(id){
   save_method = "edit";
   $('#modal_soal form')[0].reset();
   $.ajax({
      url : "ajax/ajax_soal.php?action=form_data&id="+id,
      type : "GET",
      dataType : "JSON",
      success : function(data){
         $('#modal_soal').modal('show');
         tinymce_config();
         tinymce_config_simple();
         $('.modal-title').text('Edit Soal');
         $('#id').val(data.id_soal);
         $('#soal').val(data.soal);
         $('#pil_1').val(data.pilihan_1);
         $('#pil_2').val(data.pilihan_2);
         $('#pil_3').val(data.pilihan_3);
         $('#pil_4').val(data.pilihan_4);
         $('#pil_5').val(data.pilihan_5);
         tinymce.get('soal').setContent(data.soal);
         tinymce.get('pil_1').setContent(data.pilihan_1);
         tinymce.get('pil_2').setContent(data.pilihan_2);
         tinymce.get('pil_3').setContent(data.pilihan_3);
         tinymce.get('pil_4').setContent(data.pilihan_4);
         tinymce.get('pil_5').setContent(data.pilihan_5);
         $('#kunci').val(data.kunci);
      },
      error : function(){
         alert("Tidak dapat menampilkan data!");
      }
   });
}

function save_data(){
   tes = $('#id_tes').val();
   if(save_method == "add") 
      url = "ajax/ajax_soal.php?action=insert&tes="+tes;
   else url = "ajax/ajax_soal.php?action=update";

   $.ajax({
      url : url,
      type : "POST",
      data : $('#modal_soal form').serialize(),
      success : function(data){
         if(data=="ok"){
            $('#modal_soal').modal('hide');
            table.ajax.reload();
         }else{
            alert(data);
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
         url : "ajax/ajax_soal.php?action=delete&id="+id,
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

function reset_tinymce(){
   tinyMCE.init({
      selector: ".richtext"
   });
}

function tinymce_config(){
   tinyMCE.init({
      selector: ".richtext",
      height: 150,
      setup: function (editor) {
         editor.on('change', function () {
            tinymce.triggerSave();
         });
      },
      plugins: [
         "advlist autolink lists link image charmap print preview anchor",
         "searchreplace visualblocks code fullscreen",
         "insertdatetime media table contextmenu paste imagetools responsivefilemanager tiny_mce_wiris"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | responsivefilemanager tiny_mce_wiris_formulaEditor",
	      
      external_filemanager_path:"../assets/filemanager/",
      filemanager_title:"File Manager" ,
      external_plugins: { "filemanager" : "../filemanager/plugin.min.js"}
   });
}

function tinymce_config_simple(){
   tinyMCE.init({
      selector: ".richtextsimple",
      height: 30,
      setup: function (editor) {
         editor.on('change', function () {
            tinymce.triggerSave();
         });
      },
      plugins: [
         "advlist autolink lists link image charmap print preview anchor",
         "searchreplace visualblocks code fullscreen",
         "insertdatetime media table contextmenu paste imagetools responsivefilemanager tiny_mce_wiris"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | responsivefilemanager tiny_mce_wiris_formulaEditor",
	      
      external_filemanager_path:"../assets/filemanager/",
      filemanager_title:"File Manager" ,
      external_plugins: { "filemanager" : "../filemanager/plugin.min.js"},
      menubar: false
   });
}

function form_import(){
   $('#modal_import').modal('show');
   $('.modal-title').text('Import File Excel Soal');
   $('#modal_import form')[0].reset();
}

function import_data(){
   var formdata = new FormData();      
   var file = $('#file')[0].files[0];
   formdata.append('file', file);
   $.each($('#modal_import form').serializeArray(), function(a, b){
      formdata.append(b.name, b.value);
   });
	
   tes = $('#id_tes').val();
   $.ajax({
      url: 'ajax/ajax_soal.php?action=import&tes='+tes,
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
