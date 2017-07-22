<?php
session_start();
include "../../library/config.php";
include "../../library/function_view.php";

if($_GET['action'] == "table_data"){
   $query = mysqli_query($mysqli, "SELECT * FROM edisi ORDER BY id_edisi DESC");
   $data = array();
      $no = 1;
      while($r = mysqli_fetch_array($query)){
         $row = array();
         $row[] = $no;
         $row[] = $r['edisi'];
         $row[] = create_action($r['id_edisi']);
         $data[] = $row;
         $no++;
      }
	
   $output = array("data" => $data);
   echo json_encode($output);
}

elseif($_GET['action'] == "form_data"){
   $query = mysqli_query($mysqli, "SELECT * FROM edisi WHERE id_edisi='$_GET[id]'");
   $data = mysqli_fetch_array($query);
   echo json_encode($data);
}

elseif($_GET['action'] == "insert"){
   $password = md5($_POST['password']);
   
   mysqli_query($mysqli, "INSERT INTO edisi SET edisi = '$_POST[edisi]' ");	
}

elseif($_GET['action'] == "update"){
   $password = md5($_POST['password']);
   mysqli_query($mysqli, "UPDATE edisi SET edisi = '$_POST[edisi]' WHERE id_edisi='$_POST[id]'");
}

elseif($_GET['action'] == "delete"){
   mysqli_query($mysqli, "DELETE FROM edisi WHERE id_edisi='$_GET[id]'");	
}
?>
