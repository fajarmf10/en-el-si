<script type="text/javascript" src="script/script_nilai.js"> </script>

<?php
session_start();
if(empty($_SESSION['username']) or empty($_SESSION['password']) or $_SESSION['leveluser']!="admin"){
   header('location: ../login.php');
}

include "../../library/function_view.php";
include "../../library/function_form.php";

create_title("check", "Hasil Tes");
create_button("primary", "export", "Export", "btn-add", "export_nilai()");

echo '<input type="hidden" id="id_tes" value="'.$_GET['tes'].'">
<input type="hidden" id="id_edisi" value="'.$_GET['edisi'].'">';
	  
create_table(array("ID Tim", "Nama Tim", "Jml. Benar", "Nilai"));
?>
