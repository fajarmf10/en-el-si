<?php
if(empty($_SESSION['id_tim']) or empty($_SESSION['password'])){
   header('location: login.php');
}
$tes = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM tes WHERE id_tes='$_GET[id]'"));
?>

<div class="col-sm-4 col-lg-8">

<div class="list-group">
    <div class="list-group-item list-heading">
        <h3 class="list-group-item-heading"><b>Konfirmasi Data Tes</b></h3>
    </div>
    <div class="list-group-item">
        <label class="list-group-item-heading">Kode Tes</label>
        <p class="list-group-item-text"><?= "SCHE".$tes['id_tes'] ?></p>
    </div>
    <div class="list-group-item">
        <label class="list-group-item-heading">Status Tes</label>
        <p class="list-group-item-text">Aktif</p>
    </div>
    <div class="list-group-item">
        <label class="list-group-item-heading">Edisi Schematics</label>
        <p class="list-group-item-text"><?= $_SESSION['edisi'] ?></p>
    </div>
	<div class="list-group-item">
        <label class="list-group-item-heading">Tanggal Tes </label>
        <p class="list-group-item-text"><?= tgl_indonesia($tes['tanggal']) ?></p>
    </div>
    <div class="list-group-item">
        <label class="list-group-item-heading">Waktu Tes </label>
        <p class="list-group-item-text"></p>
    </div>
    <div class="list-group-item">
        <label class="list-group-item-heading">Alokasi Waktu Tes </label>
        <p class="list-group-item-text"><?= $tes['waktu']." menit" ?></p>
    </div>
</div>

</div>            
<div class="col-sm-6 col-lg-4 pull-right">
	<div class="alert alert-warning" role="alert">
		<i class="glyphicon glyphicon-warning-sign"></i>
		Tombol MULAI akan aktif ketika waktu sekarang sudah melewati waktu mulai tes. Silahkan menunggu atau melakukan refresh halaman.
    </div>
	<div>
        <a href="?content=tes&tes=<?= $tes['id_tes'] ?>"><button type="submit" class="btn btn-danger btn-block btn-lg">MULAI</button></a>
    </div>

</div>	
