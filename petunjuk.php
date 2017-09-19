<?php
session_start();
ob_start();
if (empty($_SESSION['id_tim']) or empty($_SESSION['password'])) {
    header('location: login.php');
}
?>

<h3 class="page-header"><i class="glyphicon glyphicon-exclamation-sign"></i> Petunjuk Pengerjaan</h3>
<div class="alert alert-info">
<p>Petunjuk pengerjaan: </p>
<ul>
	<li>Pastikan anda telah terhubung ke jaringan internet</li>
	<li>Setiap tim hanya dapat login dengan 1 device (komputer)</li>
	<li>Kompetisi dimulai pada 9.00 WIB dan berakhir pada 10.40 WIB (100 menit)</li>
	<li>Tidak ada penambahan waktu bagi yang terlambat mengerjakan</li>
	<li>Penilaian : Benar +3, Salah -1, Tidak menjawab 0</li>
	<li>Pastikan minimal salah satu anggota tim anda telah tergabung dalam grup Facebook NLC Online (URL)</li>
	<li>Grup facebook ini digunakan untuk alat komunikasi antara peserta dan panitia</li>
	<li>Tidak ada revisi pada soal</li>
	<li>Apabila ada kesalahan teknis dari peserta, maka bukan tanggung jawab panitia</li>
	<li>Apabila ditemukan indikasi kecurangan, peserta akan didiskualifikasi</li>
	<li>Hasil penyisihan diumumkan maksimal 7 hari setelah babak penyisihan</li>
</ul>

</div>

<form onsubmit="return show_tes(<?= $_GET['tes']; ?>)" class="form">
<? //Editen yo
?>
<div class="form-group">
   <div class="col-md-9">
      <input type="checkbox" required><b> Saya telah membaca dan memahami petunjuk mengerjakan dengan cermat dan teliti</b> 
   </div><br>
   <div class='col-md-3'>
      <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-log-in"></i> Mulai Tes </button>
   </div>
</div>
</form>
