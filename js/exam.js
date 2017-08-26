var menit, detik;
var tes, sisa_waktu, flag;

//Ketika tombol nomor soal atau tombol navigasi diklik
function tampil_soal(no){
   sisa = $('#sisa_waktu').val();
   tes = $('#tes').val();


   $.ajax({
      url: "ajax_tes.php?action=tampil_soal",
      type: "POST",
      data: "tes=" + tes + "&sisa_waktu=" + sisa,
      success: function(data){
         if(data=="ok"){
            $('.blok-soal').removeClass('active');
            $('.soal-'+no).addClass('active');
         }else{
            alert(data);
         }
      },
      error: function(){
         alert('Tidak dapat set waktu!');
      }
   });


}

//Ketika ragu-ragu dicentang
function ragu_ragu(no){
   if($('.tombol-'+no).hasClass('yellow')){
      $('.tombol-'+no).removeClass('yellow');
   }else{
      $('.tombol-'+no).addClass('yellow');
   }
}

//Ketika tes selesai
function selesai(){
   $('#modal-selesai').modal({
      'show' : true,
      'backdrop' : 'static'
   });
}

//Ketika memilih jawaban
function kirim_jawaban(index, jawab){
   tes = $('#tes').val();
   sisa_waktu = $('#sisa_waktu').val();
   $.ajax({
      url: "ajax_tes.php?action=kirim_jawaban",
      type: "POST",
      data: "tes=" + tes + "&index=" + index + "&sisa_waktu=" + sisa_waktu + "&jawab=" + jawab,
      success: function(data){
         if(data=="ok"){
            no = index+1;
            $('.tombol-'+no).addClass("green");
         }else{
            alert(data);
         }
      },
      error: function(){
         alert('Tidak dapat mengirim jawaban!');
      }
   });
}
