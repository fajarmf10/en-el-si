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
//            $('input[type=radio]:checked ~ .huruf-pilihan').css('background-color', '#40BCD8');
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

function resetjawaban(index){
   tes = $('#tes').val();
   sisa_waktu = $('#sisa_waktu').val();
   $.ajax({
      url: "ajax_tes.php?action=resetjawaban",
      type: "POST",
      data: "tes=" + tes + "&index=" + index + "&sisa_waktu=" + sisa_waktu + "&jawab=0",
      success: function(data){
         if(data=="ok"){
            $('.tombol-'+no).removeClass("green");
            $('.huruf-pilihan').css('background-color', 'transparent');
            $("input:radio").attr("checked", false);
//           document.getElementsByClass("jadul").style.backgroundColor="transparent";
//            $('jadul').css('background-color', 'transparent');
            // $('.huruf-'+no).removeProp('checked');
            // $('.huruf-'+no).removeAttr('checked');
//            $('.huruf-').attr('checked', false);
             //document.getElementById('huruf-'+no'-1').style.color="transparent";
            // document.getElementById('huruf-'+no'-1').style.opacity="1";
             //document.getElementById('huruf-'+no'-2').style.color="transparent";
            // document.getElementById('huruf-'+no'-2').style.opacity="1";
             //document.getElementById('huruf-'+no'-3').style.color="transparent";
            // document.getElementById('huruf-'+no'-3').style.opacity="1";
             //document.getElementById('huruf-'+no'-4').style.color="transparent";
            // document.getElementById('huruf-'+no'-4').style.opacity="1";
             //document.getElementById('huruf-'+no'-5').style.color="transparent";
            // document.getElementById('huruf-'+no'-5').style.opacity="1";
            //document.getElementById('jawabannya').style.color="transparent";
            //document.getElementById('jawabannya').style.opacity="1";
         }else{
            alert(data);
         }
      },
      error: function(){
         alert('Tidak dapat mengirim jawaban!');
      }
   });
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
            /*$('label').click(function() {
               $('label').addClass('resetcok');
               var $this = $(this);
               $(this).css('background-color', '#40BCD8');
            });
            $('input:radio').change(function(){
               var $this = $(this);
               $('label').addClass('resetcok');
               $(this).css('background-color', '#40BCD8');
            });*/
            // $('input:radio').change(function(){
            //    var $this = $(this);
            //    $this.closest('.col-xs-2').find('div.highlight').removeClass('highlight');
            //    $this.closest('.q').addClass('highlight');
            // });
         }else{
            alert(data);
         }
      },
      error: function(){
         alert('Tidak dapat mengirim jawaban!');
      }
   });
}
