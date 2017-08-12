<?php
session_start();
include "library/config.php";

if(empty($_SESSION['id_tim']) or empty($_SESSION['password']) ){
   header('location: login.php');
}

//Proses ketika memilih jawaban
if($_GET['action']=="kirim_jawaban"){
   $rnilai = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM nilai WHERE id_tes='$_POST[tes]' AND id_tim='$_SESSION[id_tim]'"));

   $jawaban = explode(",", $rnilai['jawaban']);
   $index = $_POST['index'];
   $jawaban[$index] = $_POST['jawab'];
   
   $jawabanfix = implode(",", $jawaban);
   mysqli_query($mysqli, "UPDATE nilai SET jawaban='$jawabanfix', sisa_waktu='$_POST[sisa_waktu]' WHERE id_tes='$_POST[tes]' AND id_tim='$_SESSION[id_tim]'");
   
   echo "ok";
}
