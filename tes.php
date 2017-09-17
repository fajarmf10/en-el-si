<script type="text/javascript" src="js/exam.js"></script>
<script type="text/javascript" src="js/countdown.js"></script>
<?php
session_start();
include "library/config.php";

if (empty($_SESSION['id_tim']) or empty($_SESSION['password'])) {
    header('location: login.php');
}

//ubah status peserta dan membuat array untuk tabel nilai
mysqli_query($mysqli, "UPDATE peserta SET status='mengerjakan' WHERE id_tim='$_SESSION[id_tim]'");

$qwtes = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM tes WHERE id_tes='$_GET[tes]'"));
$jumsoal = $qwtes['jml_soal']/5;
$numbers = range(1, $jumsoal);
shuffle($numbers);
$arr_soal    = array();
$arr_jawaban = array();

if ($qwtes['acak_soal'] == 'Y'){
  for ($k=0;$k<$jumsoal;$k++){
    $qsoal = mysqli_query($mysqli, "SELECT id_soal FROM soal WHERE id_tes='$_GET[tes]' AND id_kelompok=$numbers[$k] LIMIT $qwtes[jml_soal]");
    $arr_soal_kelompok = array();
    $arr_jawaban_kelompok = array();
    while ($rsoal = mysqli_fetch_array($qsoal)) {
      $arr_soal_kelompok[]    = $rsoal['id_soal'];
      $arr_jawaban_kelompok[] = 0;
    }
    $arr_soal = array_merge($arr_soal, $arr_soal_kelompok);
    $arr_jawaban = array_merge($arr_jawaban, $arr_jawaban_kelompok);
  }
}
else{
    
    $qsoal = mysqli_query($mysqli, "SELECT id_soal FROM soal WHERE id_tes='$_GET[tes]' ORDER BY urut, id_soal LIMIT $qwtes[jml_soal]");
    while ($rsoal = mysqli_fetch_array($qsoal)) {
      $arr_soal[]    = $rsoal['id_soal'];
      $arr_jawaban[] = 0;
    }  
}

//kalo gaada soal
if (mysqli_num_rows($qsoal) == 0)
    die('<div class="alert alert-warning">Belum ada soal pada tes ini. Silahkan menghubungi panitia!</div>');

$acak_soal = implode(",", $arr_soal);
$jawaban   = implode(",", $arr_jawaban);

//input data ke tabel nilai jika data nilai belum ada
$qnilai = mysqli_query($mysqli, "SELECT * FROM nilai WHERE id_tim='$_SESSION[id_tim]' AND id_tes='$_GET[tes]'");
if (mysqli_num_rows($qnilai) < 1) {
    mysqli_query($mysqli, "INSERT INTO nilai SET id_tim='$_SESSION[id_tim]', id_tes='$_GET[tes]', acak_soal='$acak_soal', jawaban='$jawaban', sisa_waktu='$_SESSION[waktu_sisa]', help='Y'");
}

//timer fix
$qnilai     = mysqli_query($mysqli, "SELECT * FROM nilai WHERE id_tim='$_SESSION[id_tim]' AND id_tes='$_GET[tes]'");
$rnilai     = mysqli_fetch_array($qnilai);
$sisa_waktu = explode(":", $rnilai['sisa_waktu']);

echo '<h3 class="page-header"><b>' . $qwtes['judul'] . ' <span class="pull-right"> Sisa Waktu: <span class="menit">' . $sisa_waktu[0] . '</span> : <span class="detik"> ' . $sisa_waktu[1] . ' </span></span></b></h3>

<input type="hidden" id="tes" value="' . $_GET['tes'] . '">
<input type="hidden" id="sisa_waktu">';

echo '<div class="row">
   <div class="col-md-10"><div class="konten-ujian">';

//Output soal dari db
$arr_soal    = explode(",", $rnilai['acak_soal']);
$arr_jawaban = explode(",", $rnilai['jawaban']);
$arr_class   = array();

for ($s = 0; $s < count($arr_soal); $s++) {
    $rsoal = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM soal WHERE id_soal='$arr_soal[$s]'"));
    
    //Nomor soal
    $no     = $s + 1;
    $soal   = str_replace("../media", "media", $rsoal['soal']);
    $active = ($no == 1) ? "active" : "";
    echo '<div class="blok-soal soal-' . $no . ' ' . $active . '">
<div class="box">
<div class="row">
   <div class="col-xs-1"><div class="nomor">' . $no . '.</div></div>
   <div class="col-xs-11"><div class="soal">' . $soal . '</div> </div>
</div>';
    
    //Acak-acak
    $arr_pilihan = array();
    if ($rsoal['pilihan_1'] != "")
        $arr_pilihan[] = array(
            "no" => 1,
            "pilihan" => $rsoal['pilihan_1']
        );
    if ($rsoal['pilihan_2'] != "")
        $arr_pilihan[] = array(
            "no" => 2,
            "pilihan" => $rsoal['pilihan_2']
        );
    if ($rsoal['pilihan_3'] != "")
        $arr_pilihan[] = array(
            "no" => 3,
            "pilihan" => $rsoal['pilihan_3']
        );
    if ($rsoal['pilihan_4'] != "")
        $arr_pilihan[] = array(
            "no" => 4,
            "pilihan" => $rsoal['pilihan_4']
        );
    if ($rsoal['pilihan_5'] != "")
        $arr_pilihan[] = array(
            "no" => 5,
            "pilihan" => $rsoal['pilihan_5']
        );
    
    if ($qwtes['acak_jawaban'] == 'Y')
        shuffle($arr_pilihan);
    
    //Pilihan  
    $arr_huruf      = array(
        "A",
        "B",
        "C",
        "D",
        "E"
    );
    $arr_class[$no] = ($arr_jawaban[$s] != 0) ? "green" : "";
    for ($i = 0; $i < count($arr_pilihan); $i++) {
//        $checked = ($arr_jawaban[$s] == $arr_pilihan[$i]['no']) ? "checked" : "";
        $pilihan = str_replace("../media", "media", $arr_pilihan[$i]['pilihan']);
        echo '<div class="row pilihan">
   <div class="col-xs-2">
     <input type="radio" name="jawab-' . $no . '" data-huruf="' . $arr_huruf[$i] . '" name="jawab-' . $no . '" id="huruf-' . $no . '-' . $i . '">
     <label for="huruf-' . $no . '-' . $i . '" class="huruf-pilihan huruf" onclick="kirim_jawaban(' . $s . ', ' . $arr_pilihan[$i]['no'] . ')"> ' . $arr_huruf[$i] . ' </label>
    </div>
<div class="col-xs-10">
   <div class="teks">' . $pilihan . ' </div> 
</div>
</div>';
    }
    
    //Tombol navigasi dkk
    echo '</div><br/><div class="row"><div class="col-md-3">';
    
    $sebelumnya = $no - 1;
    if ($no != 1)
        echo '<a class="btn btn-primary btn-block" onclick="tampil_soal(' . $sebelumnya . ')">Soal Sebelumnya</a>';
/*    echo '</div>
   <div class="col-md-4 col-md-offset-1"><label class="btn btn-warning btn-block"> <input type="checkbox" autocomplete="off" onchange="ragu_ragu(' . $no . ')"> Ragu-ragu</label></div>   
<div class="col-md-3 col-md-offset-1">';*/
    echo '</div>
   <div class="col-md-4 col-md-offset-1"><a class="btn btn-warning btn-block" onclick="resetjawaban('. $s .')"> Reset </a></div>   
<div class="col-md-3 col-md-offset-1">';
    
    $berikutnya = $no + 1;
    if ($no != count($arr_soal))
        echo '<a class="btn btn-primary btn-block" onclick="tampil_soal(' . $berikutnya . ')">Soal Berikutnya</a>';
    else
        echo '<a class="btn btn-danger btn-block" onclick="selesai()"> Selesai </a>';
    
    echo '</div></div></div>';
}

echo '</div></div>
   <div class="col-md-2">
      <div class="text-center">DAFTAR SOAL</div>
   <div class="nomor-ujian"><div class="blok">';

//Nomor Soal
for ($j = 1; $j <= $s; $j++) {
    echo '<div class="blok-nomor"><div class="box"> <a class="tombol-nomor tombol-' . $j . ' ' . $arr_class[$j] . '" onclick="tampil_soal(' . $j . ')">' . $j . '</a></div></div>';
}
echo '</div></div>';

//Modal ketika selesasi
echo '<div class="modal fade" id="modal-selesai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog modal-lg">
   <div class="modal-content">
   <form  onsubmit="return selesai_tes(' . $_GET['tes'] . ')">
      
<div class="modal-header">
  <h3 class="modal-title">Apakah kamu yakin?</h3>
</div>
      
<div class="modal-body">
   <p>Pastikan semua soal telah dikerjakan sebelum mengklik selesai. Setelah klik selesai, kamu tidak dapat mengerjakan tes lagi. Yakin akan menyelesaikan tes? </p>
   <div class="chekbox-selesai"><input type="checkbox" required> Saya yakin akan menyelesaikan tes.</div>
</div>
      
<div class="modal-footer">
   <button type="submit" class="btn btn-danger" onclick="return selesai_tes(' . $_GET['tes'] . ')"> Selesai </button>
   <button type="button" class="btn btn-warning" data-dismiss="modal"> Batal </button>
</div>
      
</form></div></div></div>';
?>