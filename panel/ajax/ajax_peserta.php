<?php
session_start();
include "../../library/config.php";
include "../../library/function_view.php";

if($_GET['action'] == "table_data"){
   $query = mysqli_query($mysqli, "SELECT * FROM peserta ORDER BY id_edisi");
   $data = array();
   $no = 1;
   while($r = mysqli_fetch_array($query)){
      $edisi = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM edisi WHERE id_edisi='$r[id_edisi]'"));
      $row = array();
      $row[] = $no;
      $row[] = $r['id_tim'];
      $row[] = $r['nama'];
      $row[] = substr(md5($r['id_tim']),0,5);
      $row[] = $edisi['edisi'];
      $row[] = create_action($r['id_tim']);
      $data[] = $row;
      $no++;
   }
	
   $output = array("data" => $data);
   echo json_encode($output);
}

elseif($_GET['action'] == "form_data"){
   $query = mysqli_query($mysqli, "SELECT * FROM peserta WHERE id_tim='$_GET[id]'");
   $data = mysqli_fetch_array($query);	
   echo json_encode($data);
}

elseif($_GET['action'] == "insert"){
   $password = md5(substr(md5($_POST['id_tim']),0,5));
   $jml = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM peserta WHERE id_tim='$_POST[id_tim]'"));
   if($jml > 0){
      echo "ID Tim sudah digunakan!";
   }else{
      mysqli_query($mysqli, "INSERT INTO peserta SET
         id_tim = '$_POST[id_tim]',
         nama = '$_POST[nama]',
         password = '$password',
         id_edisi = '$_POST[edisi]',	
         status= 'off'");	
      echo "ok";
   }
}

elseif($_GET['action'] == "update"){
   mysqli_query($mysqli, "UPDATE peserta SET
      nama = '$_POST[nama]',
      id_edisi = '$_POST[edisi]'
      WHERE id_tim='$_POST[id_tim]'");
   echo "ok";
}

elseif($_GET['action'] == "delete"){
   mysqli_query($mysqli, "DELETE FROM peserta WHERE id_tim='$_GET[id]'");	
}

elseif($_GET['action'] == "import"){
   include "../../assets/excel_reader/excel_reader.php";
   $filename = strtolower($_FILES['file']['name']);
   $extensi  = substr($filename,-4);
		
   if($extensi != ".xls"){
      echo "File yang di-upload tidak berformat .xls!'";
   }else{
      $path = "../upload";			
      move_uploaded_file($_FILES['file']['tmp_name'], "$path/$filename");
			
      $file = "../upload/$filename";
			
      $data = new Spreadsheet_Excel_Reader();
      $data->read($file);
      $jdata = $data->rowcount($sheet_index=0);
			
      for($i=2; $i<=$jdata; $i++){		
         $id_tim = addslashes(str_replace(" ", "", $data->val($i,2)));
         $nama	= addslashes($data->val($i,3));
				
         $cek = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM peserta WHERE id_tim='$id_tim'"));
         if($cek > 0){
            mysqli_query($mysqli, "UPDATE peserta SET nama='$nama', id_edisi='$_POST[edisi_import]' WHERE id_tim='$id_tim'");
         }else{
            $pass = md5(substr(md5($id_tim),0,5));
            mysqli_query($mysqli, "INSERT INTO peserta SET id_tim='$id_tim', nama='$nama', id_edisi='$_POST[edisi_import]', password='$pass', status='off'");
         }
      }	
      
      unlink($file);
      echo "ok";
   }
}
?>
