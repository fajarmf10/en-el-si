<?php
session_start();
include "../library/config.php";
include "../library/function_noinject.php";

$username = antiinjeksi($_POST['username']);
$password = antiinjeksi(md5($_POST['password']));

$cekuser = mysqli_query($mysqli, "SELECT * FROM panel WHERE UNAME_PANEL='$username' AND PWD='$password'");
$jmluser = mysqli_num_rows($cekuser);
$data = mysqli_fetch_array($cekuser);
if($jmluser > 0){
   $_SESSION['username']     = $data['UNAME_PANEL'];
   $_SESSION['namalengkap']  = $data['NAMA_PANEL'];
   $_SESSION['password']     = $data['PWD'];
   $_SESSION['iduser']       = $data['ID_PANEL'];
   $_SESSION['leveluser']    = $data['LEVEL'];

   $_SESSION['timeout'] = time()+1000;
   $_SESSION['login'] = 1;
   echo "ok";
}else{
   echo "<b>Username</b> atau <b>password</b> tidak terdaftar!";
}
?>