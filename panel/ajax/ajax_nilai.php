<?php
session_start();
include "../../library/config.php";

if($_GET['action'] == "table_data"){
   $query = mysqli_query($mysqli, "SELECT * FROM peserta WHERE id_edisi='$_GET[edisi]'");
   $data = array();
   $no = 1;
   while($r = mysqli_fetch_array($query)){
      $n = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM nilai WHERE id_tim='$r[id_tim]' AND id_tes='$_GET[tes]'"));
		
      $row = array();
      $row[] = $no;
      $row[] = $r['id_tim'];
      $row[] = $r['nama'];
      $row[] = $n['jml_benar'];		
      $row[] = $n['nilai'];
      $data[] = $row;
   }
   $output = array("data" => $data);
   echo json_encode($output);
}
?>
