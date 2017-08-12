<?php
$rnilai = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM nilai WHERE id_tes='$_POST[tes]' AND id_tim='$_SESSION[id_tim]'"));
	
   $arr_soal = explode(",", $rnilai['acak_soal']);
   $jawaban = explode(",", $rnilai['jawaban']);
   $jbenar = 0;
   for($i=0; $i<count($arr_soal); $i++){
      $rsoal = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM soal WHERE id_tes='$_POST[tes]' AND id_soal='$arr_soal[$i]'"));
      if($rsoal['kunci'] == $jawaban[$i]) $jbenar++;
   }
	
   //Nilai :*
   $nilai = $jbenar/count($arr_soal)*100;
	
   mysqli_query($mysqli, "UPDATE nilai SET jml_benar='$jbenar', nilai='$nilai' WHERE id_tes='$_POST[tes]' AND id_tim='$_SESSION[id_tim]'");
   
   mysqli_query($mysqli, "UPDATE peserta SET status='on' WHERE id_tim='$_SESSION[id_tim]'"); 
   
   //Langsung diredirect logout
   header('location: ?content=keluar');   
?>