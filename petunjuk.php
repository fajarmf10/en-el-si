<?php
session_start();
ob_start();
if (empty($_SESSION['id_tim']) or empty($_SESSION['password'])) {
    header('location: login.php');
}
include "library/config.php";
include "library/function_noinject.php";
$get_tes = antiinjeksi($_GET['tes']);
?>

<h3 class="page-header"><i class="glyphicon glyphicon-exclamation-sign"></i> Petunjuk Pengerjaan</h3>
<div class="alert alert-info">
<p>Petunjuk pengerjaan: </p>
<ul>
	<li>Pastikan anda telah terhubung ke jaringan internet</li>
    <li>Peserta diharapkan mengerjakan menggunakan laptop/komputer</li>
	<li>Setiap tim hanya dapat login dengan 1 device (laptop/komputer)</li>
	<li>Tidak ada penambahan waktu bagi yang terlambat mengerjakan</li>
	<li>Tombol reset digunakan untuk mengosongkan jawaban</li>
	<li>Peserta dapat mengakhiri tes secara manual dengan tombol akhiri tes yang ada pada soal terakhir</li>
	<li>Penilaian : Benar +3, Salah -1, Tidak menjawab 0</li>
    <li>Pastikan minimal salah satu anggota tim anda telah tergabung dalam grup <a href="https://www.facebook.com/groups/129701847678188/" target="_blank">Facebook NLC Online</a></li>
	<li>Grup facebook ini digunakan untuk alat komunikasi antara peserta dan panitia</li>
	<li>Apabila ada kesalahan teknis dari peserta, maka bukan tanggung jawab panitia</li>
	<li>Apabila ditemukan indikasi kecurangan, peserta akan didiskualifikasi</li>
	<li>Hasil penyisihan diumumkan maksimal 7 hari setelah babak penyisihan</li>
	<li>Kompetisi dimulai pada 9.00 WIB dan berakhir pada 10.40 WIB (100 menit)</li>
    <li>Tidak ada revisi pada soal</li>
</ul>

</div>


<? 
	echo '<form onsubmit="return show_tes('. $get_tes. ')" class="form">'
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
