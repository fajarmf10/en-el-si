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

//Tombol edit diklik
function show_soal(tes){
   $('#content').load('view/view_soal.php?tes='+tes);	
}

//Tiap Edisi diklik
function show_nilai(edisi, tes){
    $('#content').load('view/view_nilai.php?tes=' + tes + '&edisi=' + edisi);		
}
