var table;

$(function(){
   var tes = $('#id_tes').val();
   var edisi = $('#id_edisi').val();
   table = $('.table').DataTable({
      "processing" : true,
      "pageLength" : 50,
      "paging" : false,
      "ajax" : {
         "url" : "ajax/ajax_nilai.php?action=table_data&tes=" + tes + "&edisi=" + edisi,
         "type" : "POST"
      }
   });
});

function export_nilai(){
   tes = $('#id_tes').val();
   edisi = $('#id_edisi').val();
   window.open("export/excel_nilai.php?tes=" + tes + "&edisi=" + edisi, "Export Nilai");
}
