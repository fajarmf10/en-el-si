var menit, detik;
var tes, sisa_waktu, flag;

function init(){
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
   init.called=true;
}


init();

if(init.called){
   //do nothing
}


/*$(function(){
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
   }
});*/
