<?php
session_start();
include "library/config.php";

if(empty($_SESSION['id_tim']) or empty($_SESSION['password']) ){
   header('location: login.php');
}

$edisi = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM edisi WHERE id_edisi='$_SESSION[edisi]'"));
$tes = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM tes WHERE id_tes='$_GET[tes]'"));
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
