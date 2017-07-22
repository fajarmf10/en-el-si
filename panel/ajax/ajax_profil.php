<?php
session_start();
include "../../library/config.php";

$lama = md5($_POST['lama']);
$baru = md5($_POST['baru']);
	
$cek = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM panel WHERE ID_PANEL='$_SESSION[iduser]'"));
if($cek['PWD'] != $lama){
   echo "Password lama salah!";
}else{
   mysqli_query($mysqli, "UPDATE panel SET PWD='$baru' WHERE ID_PANEL='$_SESSION[iduser]'");
   echo "ok";
}
?>