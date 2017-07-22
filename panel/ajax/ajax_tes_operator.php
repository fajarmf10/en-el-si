<?php
session_start();
include "../../library/config.php";
include "../../library/function_view.php";

if($_GET['action'] == "table_data"){
   $tgl = date('Y-m-d');
   $query = mysqli_query($mysqli, "SELECT * FROM tes WHERE tanggal='$tgl'");
   $data = array();
   $no = 1;
   while($r = mysqli_fetch_array($query)){
      
      $qedisi = mysqli_query($mysqli, "SELECT * FROM edisi t1, edisites t2 WHERE t1.id_edisi=t2.id_edisi AND t2.id_tes='$r[id_tes]'");
      $label = "";
      while($rk = mysqli_fetch_array($qedisi)){
         if($rk['aktif']=='Y') $class = 'btn-danger';
         else $class = 'btn-primary';
         $label .= '<a class="btn btn-sm '.$class.'" onclick="edit_data('.$rk['id_edisi'].','.$rk['id_tes'].')">'.$rk['edisi'].'</a> ';
      }
      
      $row = array();
      $row[] = $no;
      $row[] = $r['judul'];
      $row[] = $label;
      $data[] = $row;
      $no++;
   }
   
   $output = array("data" => $data);
   echo json_encode($output);
}

elseif($_GET['action'] == "update"){
   $cek = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM edisites WHERE id_tes='$_GET[tes]' AND id_edisi='$_GET[edisi]'"));
   $aktif = ($cek['aktif']=='Y') ? 'N' : 'Y';
   mysqli_query($mysqli, "UPDATE edisites set aktif='$aktif' WHERE id_tes='$_GET[tes]' AND id_edisi='$_GET[edisi]'");
}
?>
