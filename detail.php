<?php
session_start();
include "library/config.php";
include "library/function_convert.php";

if(empty($_SESSION['id_tim']) or empty($_SESSION['password']) ){
   header('location: login.php');
}

$edisi = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM edisi WHERE id_edisi='$_SESSION[edisi]'"));
$tes = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM tes WHERE id_tes='$_GET[tes]'"));

/*
$qsession = mysqli_query($mysqli, "SELECT * FROM session WHERE id_tim='$_SESSION[id_tim]' AND id_tes='$_GET[tes]'");
$hsession = mysqli_fetch_array($qsession);
if(mysqli_num_rows($qsession) < 1){
   //tabel session, record waktu login
//dapetin waktu sekarang, waktu login
$logintime = date("H:i:s");
//bentuk DateTime
$logindatetime = new DateTime($logintime);
   mysqli_query($mysqli, "INSERT INTO session SET id_tim='$_SESSION[id_tim]', id_tes='$_GET[tes]', login='$logintime'");
}
else{
//dapetin waktu sekarang, waktu login
$logintime = date("H:i:s");
//bentuk DateTime
$logindatetime = new DateTime($logintime);
   //kalo udah pernah kelogout
   //waktu logout dalam bentuk DateTime
   $lgt = new DateTime($hsession['logout']);
   //gunakan fitur diff di DateTime
   $interval = $lgt->diff($logindatetime);
   //dapet dalam bentuk Xjam:XMenit:XDetik
   $elapsedtime = $interval->format("%H:%i:%s");

   $tnilai = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM nilai WHERE id_tes='$_GET[tes]' AND id_tim='$_SESSION[id_tim]'"));

   //bikin DateTime ElapsedTime
   $et = new DateTime($elapsedtime);
   
   //agak panjang
   $waktu = explode(":", $tnilai['sisa_waktu']);

   $jam = hoursminute($waktu[0]);
   //$menit = $waktu[0]%60;
   $detik = $waktu[1];

   $hasil = array($jam, $detik);
   $hasil = implode(":", $hasil);
   $hasil2 = new DateTime($hasil);
   //kalo pake %, hasilnya jadi %02:%02:%02
//   $hstring = $hasil2->format("H").":".$hasil2->format("i").":".$hasil2->format("s");

/*   bikin DateTime sisa waktu dari tabel
  $sisasisa = new DateTime($sisawaktu);

   //kayak di atas
   $waktubaru = $et->diff($hasil2);
   //Sisa waktu yang baru
   $hasilnya = $waktubaru->format("%i:%s");

   //Langsung dimasukin ke tabel
   mysqli_query($mysqli, "UPDATE nilai SET sisa_waktu='$hasilnya' WHERE id_tes='$_GET[tes]' AND id_tim='$_SESSION[id_tim]'");

   //Update juga tabel session buat nyatet login yang terbaru
   mysqli_query($mysqli, "UPDATE session SET login='$logintime' WHERE id_tim='$_SESSION[id_tim]'");
}
*/
?>

<?
//Welcoming peserta. Bantu edit
?>
<h3 class="page-header"><i class="glyphicon glyphicon-user"></i> Selamat Datang di <?= $edisi['edisi'] ?></h3>
<div class="row">
   <div class="col-md-3">ID Tim</div>
   <div class="col-md-9">: <b><?= $_SESSION['id_tim']; ?> </b> </div>
</div><br/>
<div class="row">
   <div class="col-md-3">Nama Tim</div>
   <div class="col-md-9">: <b><?= $_SESSION['namatim']; ?> </b></div>
</div><br/>
<div class="row">
   <div class="col-md-3">Edisi</div>
   <div class="col-md-9">: <b><?= $edisi['edisi']; ?></b></div>
</div><br/>
<div class="row">
   <div class="col-md-3">Jml. Soal</div>
   <div class="col-md-9">: <b><?= $tes['jml_soal']; ?></b></div>
</div><br/>
<div class="row">
   <div class="col-md-3">Waktu Mengerjakan</div>
   <div class="col-md-9">: <b><?= $tes['waktu']; ?> menit</b></div>
</div><br/>

<div class="row">
   <div class="col-md-12">

<?php	
//Kalo udah tes, gabisa tes lagi
$qnilai = mysqli_query($mysqli, "SELECT * FROM nilai WHERE id_tes='$_GET[tes]' AND id_tim='$_SESSION[id_tim]'");
$tnilai = mysqli_num_rows($qnilai);
$rnilai = mysqli_fetch_array($qnilai);

if($tnilai>0 and $rnilai['nilai'] != "")  echo '<a class="btn btn-danger disabled"> Sudah mengerjakan </a>';
elseif ($rnilai['help'] != "Y") {
   # code...
   /*dibawa ke petunjuk.php dulu baru dimulai*/ 
   echo '<a class="btn btn-primary" onclick="show_petunjuk('.$_GET['tes'].')">
   <i class="glyphicon glyphicon-log-in"></i> Mulai Mengerjakan</a>';
} //Kalo udah pernah nyentang petunjuk...
else echo '<a class="btn btn-primary" onclick="show_tes('.$_GET['tes'].')">
   <i class="glyphicon glyphicon-log-in"></i> Lanjutkan Mengerjakan</a>';
?>
	
   </div>
</div><br/>
