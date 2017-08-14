<?php
  session_start();
  ob_start();
  include "library/config.php";

  $logouttime = date("H:i:s");
//  mysqli_query($mysqli, "UPDATE session SET logout='$logouttime' WHERE id_tim='$_SESSION[id_tim]'");
  mysqli_query($mysqli, "UPDATE peserta SET status='off' WHERE id_tim='$_SESSION[id_tim]'");
  
  session_destroy();
  ob_clean();
  echo "<script>
   alert('Terima kasih!'); 
   window.location = 'login.php';
   </script>";
?>
