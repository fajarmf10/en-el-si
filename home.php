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
/*
$qsession = mysqli_query($mysqli, "SELECT * FROM session WHERE id_tim='$_SESSION[id_tim]' AND id_tes='$rtes[id_tes]'");
$hsession = mysqli_fetch_array($qsession);
*/
$qnilai = mysqli_query($mysqli, "SELECT * FROM nilai WHERE id_tes='$rtes[id_tes]' AND id_tim='$_SESSION[id_tim]'");
$rnilai = mysqli_num_rows($qnilai);
$tnilai = mysqli_fetch_array($qnilai);

$jammulaidatetime = new DateTime($rtes['jam_mulai']);
$logintime     = date("H:i:s");
$logindatetime = new DateTime($logintime);

if ($logindatetime > $jammulaidatetime and $rnilai > 0) {
    $interval          = $logindatetime->diff($jammulaidatetime);
    $elapsedtime       = $interval->format("%H:%i:%s");

    //kurangi dengan durasi
    $et = new DateTime($elapsedtime); 
    $elapsedtimearr = explode(":", $elapsedtime);
    $durasikurang   = dateseconds($elapsedtimearr[0], $elapsedtimearr[1], $elapsedtimearr[2]);
        
    $waktubaru = $rtes['waktu']*60 - $durasikurang;
    if ($waktubaru < 0) {
        $waktubaru = 1;
    }
    $hasilakhir = secondshour($waktubaru);
    mysqli_query($mysqli, "UPDATE nilai SET sisa_waktu='$hasilakhir' WHERE id_tes='$rtes[id_tes]' AND id_tim='$_SESSION[id_tim]'");
}
/*
if (mysqli_num_rows($qsession) < 1 and $rtes['id_tes'] != "0") {
    //tabel session, record waktu login
    //dapetin waktu sekarang, waktu login
    $logintime     = date("H:i:s");
    //bentuk DateTime
    $logindatetime = new DateTime($logintime);
    mysqli_query($mysqli, "INSERT INTO session SET id_tim='$_SESSION[id_tim]', id_tes='$rtes[id_tes]', login='$logintime'");
} else {
    
    //dapetin waktu sekarang, waktu login
    $logintime     = date("H:i:s");
    $logindatetime = new DateTime($logintime);
    //Update juga tabel session buat nyatet login yang terbaru
    //mysqli_query($mysqli, "UPDATE session SET login='$logintime' WHERE id_tim='$_SESSION[id_tim]'");
    
    $qsession = mysqli_query($mysqli, "SELECT * FROM session WHERE id_tim='$_SESSION[id_tim]' AND id_tes='$rtes[id_tes]'");
    $hsession = mysqli_fetch_array($qsession);
    
    $initlogin         = $hsession['login'];
    //bentuk DateTime
    $initlogindatetime = new DateTime($initlogin);
    $interval          = $logindatetime->diff($initlogindatetime);
    $elapsedtime       = $interval->format("%H:%i:%s");
    
    $qnilai = mysqli_query($mysqli, "SELECT * FROM nilai WHERE id_tes='$rtes[id_tes]' AND id_tim='$_SESSION[id_tim]'");
    $rnilai = mysqli_num_rows($qnilai);
    $tnilai = mysqli_fetch_array($qnilai);

    if ($rnilai>0){
        //bikin DateTime ElapsedTime
        $et = new DateTime($elapsedtime);
        
        //agak panjang
        $waktu = explode(":", $tnilai['sisa_waktu']);
        
        $durasiawal = timeseconds($waktu[0], $waktu[1]);
        
        $elapsedtimearr = explode(":", $elapsedtime);
        $durasikurang   = dateseconds($elapsedtimearr[0], $elapsedtimearr[1], $elapsedtimearr[2]);
        
        $waktubaru = $rtes['waktu']*60 - $durasikurang;
        if ($waktubaru < 0) {
            $waktubaru = 1;
        }
        $hasilakhir = secondshour($waktubaru);

        mysqli_query($mysqli, "UPDATE nilai SET sisa_waktu='$hasilakhir' WHERE id_tes='$rtes[id_tes]' AND id_tim='$_SESSION[id_tim]'");
    }
    
}*/

//kalo ga ada tes yg aktif hari ini
if ($ttes < 1) {
    echo '<div class="alert alert-info">Schematics belum dimulai. Harap bersabar!</div>';
}

//kalo ada 1 ya lgsg dibawa ke detail tes tsb aja gan. ini buat schematicsnya nanti, pas hari H biar ga bingung milih tesnya kayak kode yg di bawah
else if ($ttes == 1) {
    /*
    echo $logintime;
    echo '<br>Init Login: ';
    echo $initlogin;
    echo '<br>Beda: ';
    echo $elapsedtime; 
    echo '<br>';
    echo $durasikurang;
    echo '<br>Sisa waktu awal: ';
    echo $tnilai['sisa_waktu']; 
    echo '<br>';
    echo $durasiawal;
    echo '<br>Hasil ngurang: ';
    echo $waktubaru;
    echo '<br>Menit detik: ';
    echo $hasilakhir;*/
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
      <th>Edisi</th>
      <th>Jml. Soal</th>
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
            echo '<a class="btn btn-danger">Sudah Mengerjakan</a>';
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