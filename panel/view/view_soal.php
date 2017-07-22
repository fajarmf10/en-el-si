<script type="text/javascript" src="../assets/tinymce/tinymce.min.js"> </script>

<script type="text/javascript" src="script/script_soal.js"> </script>

<?php
session_start();
if(empty($_SESSION['username']) or empty($_SESSION['password']) or $_SESSION['leveluser']!="admin"){
   header('location: ../login.php');
}

include "../../library/config.php";
include "../../library/function_view.php";
include "../../library/function_date.php";
include "../../library/function_form.php";

create_title("list", "Bank Soal Schematics");

echo '<hr/><div class="alert alert-info"><ul>
<li>Diharapkan untuk tidak mengupload gambar dengan size lebih dari 1 MB.</li>
<li>Disarankan untuk mengupload gambar pada Image Hosting luar, kemudian mengembednya ke dalam soal.</li>
</ul></div>';

create_button("success", "plus-sign", "Tambah", "btn-add", "form_add()");

$ru = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM tes WHERE id_tes='$_GET[tes]'"));
echo '<hr/><div class="alert alert-info"><table width="100% no-ajax">
   <tr>
      <td>Judul Tes</td><td>:<b> '.$ru['judul'].'</b></td>
      <td width="15%"></td>
      <td>Tanggal</td><td>:<b> ' .tgl_indonesia($ru['tanggal']).' </b></td>
   </tr>
   <tr>
      <td>Jml. Soal</td><td>:<b> '.$ru['jml_soal'].'</b></td>
   </tr>
</table>
<input type="hidden" id="id_tes" value="'.$_GET['tes'].'">
</div>';

create_table(array("Soal", "Aksi"));

open_form("modal_soal", "return save_data()");
   create_textarea("Soal", "soal", "richtext");
   create_textarea("Pilihan 1", "pil_1", "richtextsimple");
   create_textarea("Pilihan 2", "pil_2", "richtextsimple");
   create_textarea("Pilihan 3", "pil_3", "richtextsimple");
   create_textarea("Pilihan 4", "pil_4", "richtextsimple");
   create_textarea("Pilihan 5", "pil_5", "richtextsimple");
	
   $list = array();
   for($i=1; $i<=5; $i++){
      $list[] = array($i, $i);
   }
   create_combobox("Kunci Jawaban", "kunci", $list, 4, "", "required");
close_form();
?>