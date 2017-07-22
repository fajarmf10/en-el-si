<?php
session_start();
include "../../library/config.php";
include "../../library/function_view.php";

if($_GET['action'] == "table_data"){
   $query = mysqli_query($mysqli, "SELECT * FROM tes");
   $data = array();
   $no = 1;
   while($r = mysqli_fetch_array($query)){
      $qedisi = mysqli_query($mysqli, "SELECT * FROM edisi t1, edisites t2 WHERE t1.id_edisi=t2.id_edisi AND t2.id_tes='$r[id_tes]'");
      $label = "";
      while($rk = mysqli_fetch_array($qedisi)){
        $label .= '<span class="label label-info">'.$rk['edisi'].'</span> ';
      }
		
      $row = array();
      $row[] = $no;
      $row[] = $r['judul'];
      $row[] = $label;
      $row[] = create_action($r['id_tes'], true, false); //buka lagi function view, argument
      $data[] = $row;
      $no++;
   }
	
   $output = array("data" => $data);
   echo json_encode($output);
}

elseif($_GET['action'] == "form_data"){
   $query = mysqli_query($mysqli, "SELECT * FROM edisites WHERE id_tes='$_GET[id]'");
   $id_edisi = array();
   while($row = mysqli_fetch_array($query)){
      $id_edisi[] = $row['id_edisi'];
   }
   $data = array();
   $data['edisi'] = implode(",", $id_edisi);
   echo json_encode($data);
}

elseif($_GET['action'] == "update"){
   mysqli_query($mysqli, "DELETE FROM edisites WHERE id_tes='$_POST[id]'");
   $edisi = $_POST['edisi'];
   foreach($edisi as $ed){
      mysqli_query($mysqli, "INSERT INTO edisites SET id_tes='$_POST[id]', id_edisi='$ed'");
   }
}
?>
