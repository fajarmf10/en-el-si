<script type="text/javascript" src="script/script_peserta.js"> </script>

<?php
session_start();
if(empty($_SESSION['username']) or empty($_SESSION['password']) or $_SESSION['leveluser']!="admin"){
   header('location: ../login.php');
}

include "../../library/config.php";
include "../../library/function_view.php";
include "../../library/function_form.php";

create_title("list-alt", "Manajemen Peserta");
create_button("success", "plus-sign", "Tambah", "btn-add", "form_add()");
create_button("primary", "import", "Import", "btn-import", "form_import()");

create_table(array("ID Tim", "Nama Tim", "Password", "Edisi", "Aksi"));

open_form("modal_peserta", "return save_data()");
   
   echo'<div class="form-group">
   <label for="id_tim" class="col-sm-2 control-label"> ID Tim</label>
   <div class="col-sm-4">
      <input type="number" class="form-control" id="id_tim" name="id_tim" min="201701001" required>
   </div> </div>';

   create_textbox("Nama Tim", "nama", "text", 6, "", "required");
	
   $qedisi = mysqli_query($mysqli, "SELECT * FROM edisi");
   $list = array();
   while($rk = mysqli_fetch_array($qedisi)){
      $list[] = array($rk['id_edisi'], $rk['edisi']);
   }
   create_combobox("Edisi", "edisi", $list, 4, "", "required");
close_form();

open_form("modal_import", "return import_data()");
   create_textbox("Pilih file .xls", "file", "file", 6, "", "required");
   $qedisi = mysqli_query($mysqli, "SELECT * FROM edisi");
   $list = array();
   while($rk = mysqli_fetch_array($qedisi)){
      $list[] = array($rk['id_edisi'], $rk['edisi']);
   }
   create_combobox("Edisi", "edisi_import", $list, 4, "", "required");
close_form("import", "Import");
?>