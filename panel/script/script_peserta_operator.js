var table;

$(function(){
   table = $('.table').DataTable({
     "processing" : true,
     "ajax" : {
       "url" : "ajax/ajax_peserta_operator.php?action=table_data",
       "type" : "POST"
     }
   });
});

function refresh_data(){
   table.ajax.reload();
}

function reset_login(id){
   if(confirm("Apakah yakin akan mereset login peserta dengan ID Tim "+id+" ?")){
      $.ajax({
         url : "ajax/ajax_peserta_operator.php?action=reset_login&id_tim="+id,
         type : "GET",
         success : function(data){
            table.ajax.reload();
         },
         error : function(){
            alert("Tidak dapat mereset login!");
         }
      });
   }
}
