<script type="text/javascript" src="js/exam.js"></script>
<?php
session_start();
include "library/config.php"; 

if(empty($_SESSION['id_tim']) or empty($_SESSION['password']) ){
   header('location: login.php');
}


//ubah status peserta dan membuat array untuk tabel nilai
mysqli_query($mysqli, "UPDATE peserta SET status='mengerjakan' WHERE id_tim='$_SESSION[id_tim]'");

$qwtes = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM tes WHERE id_tes='$_GET[tes]'"));
if($qwtes['acak_soal']=='Y') $qsoal = mysqli_query($mysqli, "SELECT * FROM soal WHERE id_tes='$_GET[tes]' ORDER BY rand() LIMIT $qwtes[jml_soal]");
else $qsoal = mysqli_query($mysqli, "SELECT * FROM soal WHERE id_tes='$_GET[tes]' ORDER BY urut, id_soal LIMIT $qwtes[jml_soal]");

//kalo gaada soal
if(mysqli_num_rows($qsoal)==0) die('<div class="alert alert-warning">Belum ada soal pada tes ini. Silahkan menghubungi panitia!</div>');

$arr_soal = array();
$arr_jawaban = array();
while($rsoal = mysqli_fetch_array($qsoal)){
   $arr_soal[] = $rsoal['id_soal'];
   $arr_jawaban[] = 0;
}

$acak_soal = implode(",", $arr_soal);
$jawaban = implode(",", $arr_jawaban);

//input data ke tabel nilai jika data nilai belum ada
$qnilai = mysqli_query($mysqli, "SELECT * FROM nilai WHERE id_tim='$_SESSION[id_tim]' AND id_tes='$_GET[tes]'");
if(mysqli_num_rows($qnilai) < 1){
   mysqli_query($mysqli, "INSERT INTO nilai SET id_tim='$_SESSION[id_tim]', id_tes='$_GET[tes]', acak_soal='$acak_soal', jawaban='$jawaban', sisa_waktu='$qwtes[waktu]:00'");
}

//timer haruse fix seh
$qnilai = mysqli_query($mysqli, "SELECT * FROM nilai WHERE id_tim='$_SESSION[id_tim]' AND id_tes='$_GET[tes]'");
$rnilai = mysqli_fetch_array($qnilai);
$sisa_waktu = explode(":", $rnilai['sisa_waktu']);

echo '<div class="padding-20">';
echo '<div class="list-group">';

echo '<div class="list-group-item floating">
   <b>NO SOAL</b><span class="no-soal">1</span>
   <div class="pull-right blok-waktu"><label> Sisa Waktu </label> <span class="waktu"><span class="menit">'.$sisa_waktu[0].'</span> : <span class="detik"> '.$sisa_waktu[1].' </span></span></div>
   </div>';

echo '<div class="list-group-item bg-abu">
      Ukuran font soal : <span class="ukuran-font"><a class="kecil" data-size="16">A</a> <a class="sedang" data-size="18">A</a> <a class="besar" data-size="20">A</a></span>
   </div>';
   
echo '<div class="list-group-item">';
echo'<input type="hidden" id="tes" value="'.$_GET['tes'].'">
   <input type="hidden" id="sisa_waktu">';
   
echo '<div class="row">
   <div class="col-md-12"><div class="konten-ujian">';   

//Output soal dari db
$arr_soal = explode(",", $rnilai['acak_soal']);
$arr_jawaban = explode(",", $rnilai['jawaban']);
$arr_class = array();

for($s=0; $s<count($arr_soal); $s++){
   $rsoal = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM soal WHERE id_soal='$arr_soal[$s]'"));

//Nomor soal
   $no = $s+1;
   $soal = str_replace("../media", "media", $rsoal['soal']);
   $active = ($no==1) ? "active" : "";
   echo '<div class="blok-soal soal-'.$no.' '.$active.'">
         <div class="box">
         <div class="soal">';
   echo $soal;
   echo'</div>';
   
   echo '<table class="row pilihan">';
   
//Acak-acak
   $arr_pilihan = array();
   if($rsoal['pilihan_1']!="")$arr_pilihan[] = array("no" => 1, "pilihan" => $rsoal['pilihan_1']);
   if($rsoal['pilihan_2']!="")$arr_pilihan[] = array("no" => 2, "pilihan" => $rsoal['pilihan_2']);
   if($rsoal['pilihan_3']!="")$arr_pilihan[] = array("no" => 3, "pilihan" => $rsoal['pilihan_3']);
   if($rsoal['pilihan_4']!="")$arr_pilihan[] = array("no" => 4, "pilihan" => $rsoal['pilihan_4']);
   if($rsoal['pilihan_5']!="") $arr_pilihan[] = array("no" => 5, "pilihan" => $rsoal['pilihan_5']);
   
if($qwtes['acak_jawaban']=='Y') shuffle($arr_pilihan);

//Pilihan
   $arr_huruf = array("A","B","C","D","E");  
   $arr_class[$no] = ($arr_jawaban[$s]!=0) ? "green" : "";
   for($i=0; $i<count($arr_pilihan); $i++){
      $checked = ($arr_jawaban[$s] == $arr_pilihan[$i]['no']) ? "checked" : "";
      $pilihan = str_replace("../media", "media", $arr_pilihan[$i]['pilihan']);
      echo '<tr>
      <td width="50"></td>
      <td width="60">
         <input type="radio" class="jawab-'.$no.'" data-huruf="'.$arr_huruf[$i].'" name="jawab-'.$no.'" id="huruf-'.$no.'-'.$i.'" '.$checked.'>
         <label for="huruf-'.$no.'-'.$i.'" class="huruf-pilihan huruf-'.$arr_huruf[$i].'" onclick="kirim_jawaban('.$s.', '.$arr_pilihan[$i]['no'].')"></label>
      </td>
      <td valign="top">
         <div class="teks">'.$pilihan.' </div> 
      </td>
      </tr>';
   }

   echo '</table></div>';
   
//8 Tombol navigasi dkk
   
   echo'<br><br><div class="row"><div class="col-md-2">';
   
   $sebelumnya = $no-1;
   if($no != 1) echo '<a class="btn btn-default btn-block" onclick="tampil_soal('.$sebelumnya.')"><span class="btn-left"></span> SOAL SEBELUMNYA</a>';
   else echo '<a class="btn btn-default btn-block"><span class="btn-left"></span>SOAL SEBELUMNYA</a>';
   
   echo '</div>
   <div class="col-md-2 col-md-offset-3 geser"><label class="btn btn-warning btn-block"> <input type="checkbox" autocomplete="off" onchange="ragu_ragu('.$no.')"> RAGU-RAGU </label></div>   
   <div class="col-md-2 col-md-offset-3 geser">';
   
   $berikutnya = $no+1;
   if($no != count($arr_soal)) echo '<a class="btn btn-primary btn-block" onclick="tampil_soal('.$berikutnya.')"> SOAL BERIKUTNYA <span class="btn-right"></span></a>';
   else echo '<a class="btn btn-danger btn-block" onclick="selesai()"> SELESAI <span class="btn-right"></span> </a>';

   echo '</div>
      </div>
      </div>';
}

echo '</div></div></div>';

echo '</div></div></div>';

//Nomor soal
echo '<div class="tombol1 tombol-sidebar" onclick="masuk()"></div><div class="tombol2 tombol-sidebar" onclick="keluar()">DAFTAR SOAL</div>';
echo '<div class="nomor-ujian"><div class="blok">';
for($j=1; $j<=$s; $j++){
   if($j==1) $cclass = "blue";
   else $cclass = "";
   
   echo '<div class="blok-nomor"><div class="box"> <a class="tombol-nomor tombol-'.$j.' '.$cclass.' '.$arr_class[$j].'" onclick="tampil_soal('.$j.')" data-id="'.$j.'">'.$j.'</a> <span class="huruf"></span></div></div>';
}

echo '</div></div>';

//Modal ketika selesasi
echo '<div class="modal fade" id="modal-selesai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog">
   <div class="modal-content">
   <form  method="post" action="?content=selesai">
      
<div class="modal-header">
  <h3 class="modal-title">Schematics ITS</h3>
</div>
      
<div class="modal-body">
   <div class="row">
   <div class="col-md-3 text-center">
      <br><br>
      <img src="images/warning.png" width="80">
   </div>
   <div class="col-md-9">
      <br>Apakah anda yakin akan mengakhiri tes?<br>
      Semua jawaban yang anda kirimkan tidak bisa diubah lagi setelah mengklik tombol logout.

      <br><br>Centang, kemudian tekan tombol Selesai
      <input type="hidden" name="tes" value="'.$_GET['tes'].'">
      <div class="chekbox-selesai"><input type="checkbox" required> Saya yakin dengan semua jawaban yang telah saya pilih. Untuk selanjutnya, semua saya serahkan kepada panitia.</div><br>
   </div>
   </div>
</div>
      
<div class="modal-footer">
   <div class="row">
   <div class="col-md-6">
      <button type="submit" class="btn btn-success btn-block"> SELESAI </button>
   </div>
   <div class="col-md-6">
      <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"> TIDAK </button>
   </div>
   </div>
</div>
      
</form></div></div></div>';
?>

