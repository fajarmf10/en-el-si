var menit, detik;
var tes, sisa_waktu;
var font_size;
var nomor_id, pilihan;

//Counting down
$(function(){		
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
         $('#modal-selesai .modal-body').text("Waktu sudah habis. Terima kasih telah mengikuti Schematics, semoga beruntung!");
         $('#modal-selesai .btn-warning').hide();
      }
   }, 1000);

   $('.ukuran-font a').each(function(){
      $(this).click(function(){
         font_size = $(this).attr('data-size');

         $('.konten-ujian').css('font-size', font_size+'px');
         $('.konten-ujian td').css('font-size', font_size+'px');
      });
   });

   $('.tombol-nomor').each(function(){
      nomor_id = $(this).attr('data-id');
      pilihan = $('.jawab-'+nomor_id+':checked').attr('data-huruf');
      $(this).next().text(pilihan);
   });

});

//Ketika tombol nomor soal atau tombol navigasi diklik
function tampil_soal(no){
   $('.blok-soal').removeClass('active');
   $('.soal-'+no).addClass('active');

   $('.tombol-nomor').removeClass("blue");
   $('.tombol-'+no).addClass("blue");
   $('.no-soal').text(no);
}

//Ketika ragu-ragu dicentang
function ragu_ragu(no){
   if($('.tombol-'+no).hasClass('yellow')){
      $('.tombol-'+no).removeClass('yellow');
   }else{
      $('.tombol-'+no).addClass('yellow');
   }
}

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
            hurufpilih = $('.jawab-'+no+':checked').attr('data-huruf');
            $('.tombol-'+no).next().text(hurufpilih);
         }else{
            alert(data);
         }
      },
      error: function(){
         alert('Tidak dapat mengirim jawaban!');
      }
   });
}

function masuk(){
   $('.nomor-ujian').animate({'right': '-315px'});
   $('.tombol2').show().animate({'right': '0'});
   $('.tombol1').hide().animate({'right': '0'});
   $('.geser').addClass('col-md-offset-3');
}
function keluar(){
   $('.nomor-ujian').animate({'right': '15px'});
   $('.tombol2').hide().animate({'right': '315px'});
   $('.tombol1').show().animate({'right': '315px'});
   $('.geser').removeClass('col-md-offset-3');
}
