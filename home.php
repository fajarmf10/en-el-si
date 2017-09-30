<?php
session_start();
ob_start();
include "library/config.php";
include "library/function_convert.php";

if (empty($_SESSION['id_tim']) or empty($_SESSION['password'])) {
    header('location: login.php');
}

//cek jumlah tes. sebenernya ini buat warmup sih, mau dibikin banyak tes dalam sehari, coba load-upnya lancar atau enggak. kalo ga butuh ya ntar ane edit gan
$tgl      = date('Y-m-d');
$qtes     = mysqli_query($mysqli, "SELECT * FROM tes t1, edisites t2 WHERE t1.tanggal='$tgl' AND t1.id_tes=t2.id_tes AND t2.id_edisi='$_SESSION[edisi]' AND t2.aktif='Y'");
$ttes     = mysqli_num_rows($qtes);
$rtes     = mysqli_fetch_array($qtes);

$jammulaidatetime = new DateTime($rtes['jam_mulai']);
$logintime     = date("H:i:s");
$logindatetime = new DateTime($logintime);
$mulai = 0;

if ($logindatetime > $jammulaidatetime) {
    $mulai = 1;
}
else {
  $mulai = 0;
}

//kalo ga ada tes yg aktif hari ini
if ($ttes < 1 or $mulai == 0) {
    echo '<div class="alert alert-info">
    <p>Schematics belum dimulai. Harap bersabar!</p></div>
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
</ul>';
}

//kalo ada 1 ya lgsg dibawa ke detail tes tsb aja gan. ini buat schematicsnya nanti, pas hari H biar ga bingung milih tesnya kayak kode yg di bawah
else if ($ttes == 1) {
    echo '<script> show_detail(' . $rtes['id_tes'] . '); </script>';
}
//ini buat warmupnya, dilist ada berapa tes yg aktif. desain seadanya
else {
    
    echo '<div class="padding-20">';
    echo '<div class="panel panel-default height-450">';
    echo '<div class="panel-heading"><h3><b>Daftar Tes</h3></b></div>';
    echo '<div class="panel-body">
   <table class="table table-striped"><thead>
   <tr>
      <th>No</th>
      <th>Judul</th>
      <th>Jml Soal</th>
      <th>Waktu</th>
      <th></th>
   </tr></thead><tbody>';
    
    $qtes = mysqli_query($mysqli, "SELECT * FROM tes t1, edisites t2 WHERE t1.tanggal='$tgl' AND t1.id_tes=t2.id_tes AND t2.id_edisi='$_SESSION[edisi]' AND t2.aktif='Y'");
    $no   = 1;
    while ($r = mysqli_fetch_array($qtes)) {
        
        $edisites  = array();
        $qedisites = mysqli_query($mysqli, "SELECT * FROM edisi t1, edisites t2 WHERE  t1.id_edisi=t2.id_edisi AND t2.id_tes='$r[id_tes]'");
        while ($rku = mysqli_fetch_array($qedisites)) {
            $edisites[] = $rku['edisi'];
        }
        
        echo '<tr>
         <td>' . $no . '</td>
         <td>' . implode($edisites, ", ") . '</td>
         <td>' . $r['jml_soal'] . '</td>
        <td>' . $r['waktu'] . ' menit</td>
        <td>';
        
        //kalo nilai udah ada tampilin tombol Sudah Mengerjakan, jika belum ada tampilin tombol Kerjakan
        $qnilai = mysqli_query($mysqli, "SELECT * FROM nilai WHERE id_tes='$r[id_tes]' AND id_tim='$_SESSION[id_tim]'");
        $tnilai = mysqli_num_rows($qnilai);
        $rnilai = mysqli_fetch_array($qnilai);
        
        if ($tnilai > 0 and $rnilai['nilai'] != "")
            echo '<a onclick="show_detail(' . $r['id_tes'] . ')" class="btn btn-warning">Lanjutkan Mengerjakan</a>';
        else
            echo '<a onclick="show_detail(' . $r['id_tes'] . ')" class="btn btn-success"><i class="glyphicon glyphicon-edit"></i> Kerjakan</a>';
        echo '</td>
     </tr>';
        $no++;
    }
    
    echo '</tbody></table>';
    
    echo '</div></div></div>';
}




?>