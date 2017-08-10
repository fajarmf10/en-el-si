<script type="text/javascript" src="script/script_tes_operator.js"> </script>

<?php
session_start();
if(empty($_SESSION['username']) or empty($_SESSION['password']) or $_SESSION['leveluser']!="operator"){
 header('location: ../login.php');
}

include "../../library/config.php";
include "../../library/function_view.php";

create_title("edit", "Pengaturan Tes");

echo '<hr/><div class="alert alert-info"><p>Klik pada nama <i>edisi</i> untuk <b>mengaktifkan</b> atau <b>menon-aktifkan</b> tes pada <i>edisi</i> tersebut!</p>
	<p>Jika tombol <span style="color: red">berwarna merah</span>, berarti <i>Tes</i> sudah diaktifkan. Klik untuk <b>menon-aktifkan</b>.</p>
</div>';

create_table(array("Judul Tes", "Edisi"));
?>
