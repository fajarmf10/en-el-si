<script type="text/javascript" src="script/script_edisites.js"> </script>

<?php
session_start();
if(empty($_SESSION['username']) or empty($_SESSION['password']) or $_SESSION['leveluser']!="admin"){
	header('location: ../login.php');
}

include "../../library/config.php";
include "../../library/function_view.php";
include "../../library/function_form.php";

create_title("sort-by-attributes", "Manajemen Edisi dan Tes");

echo '<hr/><div class="alert alert-info"><ul>
<li>Silahkan assign tiap-tiap tes ke dalam edisi Schematics.</li>
</br><li>Contoh : Dalam edisi Schematics 2014, ada tes warmup panitia, tes warmup peserta, dan tes sebenarnya.</li>
</ul></div>';

create_table(array("Judul Tes", "Edisi", "Aksi"));

open_form("modal_edisites", "return save_data()");
   $qedisi = mysqli_query($mysqli, "SELECT * FROM edisi");
   $list = array();
   while($rk = mysqli_fetch_array($qedisi)){
      $list[] = array($rk['id_edisi'], $rk['edisi']);
   }
   create_checkbox("Edisi", "edisi", $list);	
close_form();
?>
