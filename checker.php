<?php
session_start();
include "library/config.php";
include "library/function_noinject.php";

$id_tim = antiinjeksi($_POST['id_tim']);
$password = antiinjeksi(md5($_POST['password']));

$cekuser = mysqli_query($mysqli, "SELECT * FROM peserta WHERE id_tim='$id_tim' AND password='$password'");
$jmluser = mysqli_num_rows($cekuser);
$data = mysqli_fetch_array($cekuser);
if($jmluser > 0){
   if($data['status'] == "off"){
/*

     $_SESSION['username']    = $data['id_tim'];
     $_SESSION['namatim']   = $data['nama'];
     $_SESSION['password']    = $data['password'];
     $_SESSION['edisi']     = $data['id_edisi'];
*/

     $_SESSION['id_tim']        = $data['id_tim'];
     $_SESSION['namatim']       = $data['nama'];
     $_SESSION['password']      = $data['password'];
     $_SESSION['edisi']         = $data['id_edisi'];

     mysqli_query($mysqli, "UPDATE peserta SET status='on' WHERE id_tim='$data[id_tim]'");
     echo "ok";
   }else{
      echo "Tim sedang <b>Login</b>. Hubungi panitia untuk informasi lebih lanjut!";
   }
}else{
   echo "<b>ID Tim</b> atau <b>password</b> tidak terdaftar!</br>Jika merasa ada kesalahan, silahkan hubungi panitia.";
}
?>