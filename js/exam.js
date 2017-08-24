var menit, detik;
var tes, sisa_waktu, flag;

//Counting down
$(function(){     
   flag=0;
   if (flag==0){
         setInterval(function(){
            menit = parseInt($('.menit').text());  
            detik = parseInt($('.detik').text());
           
            detik--;
            if(detik<0 && menit>0){
               menit--;
               detik = 59;
            }

            if(menit<=0) menit = 0;
            if(menit<10) menit = "0"+menit;
            if(detik<10) detik = "0"+detik;
            
            $('.menit').text(menit);
            $('.detik').text(detik);
            $('#sisa_waktu').val(menit+':'+detik);
            
            if(menit == "00" && detik == "00"){
               selesai();
               $('#modal-selesai .modal-title').text("Waktu Sudah Habis!");
               $('#modal-selesai .modal-body').text("Waktu sudah habis. Terima kasih telah mengerjakan tes, semoga beruntung!");
               $('#modal-selesai .btn-warning').hide();
            }
         }, 1000);
         flag=1;
   }
});

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
