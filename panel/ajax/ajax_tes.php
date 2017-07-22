<?php
session_start();
include "../../library/config.php";
include "../../library/function_date.php";
include "../../library/function_view.php";

if($_GET['action'] == "table_data"){
   $query = mysqli_query($mysqli, "SELECT * FROM tes ORDER BY id_tes DESC");
   $data = array();
   $no = 1;
   while($r = mysqli_fetch_array($query)){
      $qsoal = mysqli_query($mysqli, "SELECT * FROM soal WHERE id_tes='$r[id_tes]'");
      $btn_soal = '<a class="btn btn-primary btn-sm" onclick="show_soal('.$r['id_tes'].')"><i class="glyphicon glyphicon-edit"></i> Edit &nbsp;&nbsp;<span class="label label-warning">'.mysqli_num_rows($qsoal).'</span></a>';

      $qedisi = mysqli_query($mysqli, "SELECT * FROM edisi t1, edisites t2 WHERE t1.id_edisi=t2.id_edisi AND t2.id_tes='$r[id_tes]'");
      $label = "";

      while($rk = mysqli_fetch_array($qedisi)){
         $jml = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM nilai t1, peserta t2 WHERE t1.id_tes='$rk[id_tes]' AND t1.id_tim=t2.id_tim AND t2.id_edisi='$rk[id_edisi]'"));
         $label .= '<a class="btn btn-xs btn-info" style="margin-bottom: 5px" onclick="show_nilai('.$rk['id_edisi'].','.$rk['id_tes'].')">'.$rk['edisi'].' &nbsp;&nbsp; <span class="label label-warning">'.$jml.'</span></a> ';
   }

      $row = array();
      $row[] = $no;
      $row[] = $r['judul'];
      $row[] = tgl_indonesia($r['tanggal']);
      $row[] = $r['waktu'].' menit';
      $row[] = $r['jml_soal'];

      $row[] = $r['acak_soal'];
      $row[] = $r['acak_jawaban'];

      $row[] = $btn_soal;
      $row[] = $label;
      $row[] = create_action($r['id_tes'], true, false);
      $data[] = $row;
      $no++;
   }
	
   $output = array("data" => $data);
   echo json_encode($output);
}

//Menampilkan data ke form
elseif($_GET['action'] == "form_data"){
   $query = mysqli_query($mysqli, "SELECT * FROM tes WHERE id_tes='$_GET[id]'");
   $data = mysqli_fetch_array($query);	
   echo json_encode($data);
}

//Menambah data
elseif($_GET['action'] == "insert"){
   mysqli_query($mysqli, "INSERT INTO tes SET
      judul = '$_POST[judul]',
      tanggal = '$_POST[tanggal]',
      waktu = '$_POST[waktu]',
      acak_soal = '$_POST[acak_soal]',
      acak_jawaban = '$_POST[acak_jawaban]',
      jml_soal = '$_POST[jml_soal]'");	
}

//Mengedit data
elseif($_GET['action'] == "update"){
   mysqli_query($mysqli, "UPDATE tes SET
      judul = '$_POST[judul]',
      tanggal = '$_POST[tanggal]',
      waktu = '$_POST[waktu]',
      jml_soal = '$_POST[jml_soal]',
      acak_soal = '$_POST[acak_soal]',
      acak_jawaban = '$_POST[acak_jawaban]'
      WHERE id_tes='$_POST[id]'");	
}

elseif($_GET['action'] == "delete"){
   mysqli_query($mysqli, "DELETE FROM tes WHERE id_tes='$_GET[id]'");	
}
?>
