<?php
session_start();
include "library/config.php";
include "library/function_convert.php";

if (empty($_SESSION['id_tim']) or empty($_SESSION['password'])) {
    header('location: login.php');
}

$edisi = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM edisi WHERE id_edisi='$_SESSION[edisi]'"));
$tes   = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM tes WHERE id_tes='$_GET[tes]'"));

//
// $qtes     = mysqli_query($mysqli, "SELECT * FROM tes t1, edisites t2 WHERE t1.tanggal='$tgl' AND t1.id_tes=t2.id_tes AND t2.id_edisi='$_SESSION[edisi]' AND t2.aktif='Y'");
// $ttes     = mysqli_num_rows($qtes);
// $rtes     = mysqli_fetch_array($qtes);
//

$qnilai = mysqli_query($mysqli, "SELECT * FROM nilai WHERE id_tes='$_GET[tes]' AND id_tim='$_SESSION[id_tim]'");
$rnilai = mysqli_num_rows($qnilai);
$tnilai = mysqli_fetch_array($qnilai);

if ($rnilai < 1) {
  # checking waktunya, kali aja pesertanya telat login
  $jammulaidatetime = new DateTime($tes['jam_mulai']);
  $logintime        = date("H:i:s");
  $logindatetime    = new DateTime($logintime);
  if ($logindatetime > $jammulaidatetime) {
    $interval          = $logindatetime->diff($jammulaidatetime);
    $elapsedtime       = $interval->format("%H:%i:%s");

    $et = new DateTime($elapsedtime);
    $elapsedtimearr = explode(":", $elapsedtime);
    $durasikurang   = dateseconds($elapsedtimearr[0], $elapsedtimearr[1], $elapsedtimearr[2]);

    $waktubaru = $tes['waktu']*60 - $durasikurang;
    if ($waktubaru < 0) {
        $waktubaru = 1;
    }
    $hasilakhir = secondshour($waktubaru);

    # simpan aja di session
    $_SESSION['jadinya'] = $hasilakhir;
  }
  else{
    $_SESSION['jadinya']=$tes['waktu'];
    $_SESSION['jadinya'].=":00";
  }
}
else{
  # Kita cuman perlu update sisa_waktu
  $jammulaidatetime = new DateTime($tes['jam_mulai']);
  $logintime        = date("H:i:s");
  $logindatetime    = new DateTime($logintime);

  $mulai = 1;
  $interval          = $logindatetime->diff($jammulaidatetime);
  $elapsedtime       = $interval->format("%H:%i:%s");

  //kurangi dengan durasi
  $et = new DateTime($elapsedtime); 
  $elapsedtimearr = explode(":", $elapsedtime);
  $durasikurang   = dateseconds($elapsedtimearr[0], $elapsedtimearr[1], $elapsedtimearr[2]);
        
  $waktubaru = $tes['waktu']*60 - $durasikurang;
  if ($waktubaru < 0) {
      $waktubaru = 1;
  }
  $hasilakhir = secondshour($waktubaru);

  mysqli_query($mysqli, "UPDATE nilai SET sisa_waktu='$hasilakhir' WHERE id_tes='$tes[id_tes]' AND id_tim='$_SESSION[id_tim]'");  
}






?>

<?
//Welcoming peserta. Bantu edit
?>
<h3 class="page-header"><i class="glyphicon glyphicon-user"></i> Selamat Datang di <?= $edisi['edisi'] ?></h3>
<div class="row">
   <div class="col-md-3 col-xs-4">ID Tim</div>
   <div class="col-md-9 col-xs-8">: <b><?= $_SESSION['id_tim']; ?> </b> </div>
</div><br/>
<div class="row">
   <div class="col-md-3 col-xs-4">Nama Tim</div>
   <div class="col-md-9 col-xs-8">: <b><?= $_SESSION['namatim']; ?> </b></div>
</div><br/>
<div class="row">
   <div class="col-md-3 col-xs-4">Edisi</div>
   <div class="col-md-9 col-xs-8">: <b><?= $edisi['edisi']; ?></b></div>
</div><br/>
<div class="row">
   <div class="col-md-3 col-xs-4">Jml. Soal</div>
   <div class="col-md-9 col-xs-8">: <b><?= $tes['jml_soal']; ?></b></div>
</div><br/>
<div class="row">
   <div class="col-md-3 col-xs-4">Waktu Mengerjakan</div>
   <div class="col-md-9 col-xs-8">: <b><?= $tes['waktu']; ?> menit</b></div>
</div><br/>

<div class="row">
   <div class="col-md-12">

<?php
//Kalo udah tes, gabisa tes lagi
$qnilai = mysqli_query($mysqli, "SELECT * FROM nilai WHERE id_tes='$_GET[tes]' AND id_tim='$_SESSION[id_tim]'");
$tnilai = mysqli_num_rows($qnilai);
$rnilai = mysqli_fetch_array($qnilai);

if ($tnilai > 0 and $rnilai['nilai'] != "")
    echo '<a class="btn btn-danger disabled"> Sudah mengerjakan </a>';
elseif ($rnilai['help'] != "Y") {
    # code...
    /*dibawa ke petunjuk.php dulu baru dimulai*/
    echo '<a class="btn btn-primary" onclick="show_petunjuk(' . $_GET['tes'] . ')">
   <i class="glyphicon glyphicon-log-in"></i> Mulai Mengerjakan</a>';
} //Kalo udah pernah nyentang petunjuk...
else
    echo '<a class="btn btn-primary" onclick="show_tes(' . $_GET['tes'] . ')">
   <i class="glyphicon glyphicon-log-in"></i> Lanjutkan Mengerjakan</a>';
?>
   
   </div>
</div><br/>
