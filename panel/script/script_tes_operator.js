var save_method, table;

$(function(){
   table = $('.table').DataTable({
     "processing" : true,
     "ajax" : {
     "url" : "ajax/ajax_tes_operator.php?action=table_data",
        "type" : "POST"
     }
   });
});
	
function edit_data(edisi, tes){
   $.ajax({
      url : "ajax/ajax_tes_operator.php?action=update&edisi=" + edisi + "&tes=" + tes,
   type : "GET",
   success : function(data){
      table.ajax.reload();
   },
      error : function(){
        alert('Tidak dapat mengubah data');
      }
   });		
}
