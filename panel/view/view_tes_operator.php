<script type="text/javascript" src="script/script_tes_operator.js"> </script>

<?php
session_start();
if(empty($_SESSION['username']) or empty($_SESSION['password']) or $_SESSION['leveluser']!="operator"){
 header('location: ../login.php');
}

include "../../library/config.php";
include "../../library/function_view.php";

create_title("edit", "Pengaturan Tes");

echo '<hr/><div class="alert alert-info"><p>Klik pada nama edisi untuk mengaktifkan atau menon-aktifkan tes pada edisi tersebut!</p></div>';

create_table(array("Judul Tes", "Edisi"));
?>
