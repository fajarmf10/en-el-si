<link rel="stylesheet" type="text/css" href="../assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
<script type="text/javascript" src="../assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<script type="text/javascript" src="script/script_tes.js"> </script>

<?php
session_start();
if(empty($_SESSION['username']) or empty($_SESSION['password']) or $_SESSION['leveluser']!="admin"){
   header('location: ../login.php');
}

include "../../library/config.php";
include "../../library/function_view.php";
include "../../library/function_form.php";

create_title("edit", "Manajemen Tes");

echo '<hr/><div class="alert alert-info"><ul>
<li>Klik tombol edit pada kolom Soal untuk menambahkan atau menghapus soal.</li>
<li>Klik pada section <b>Lihat Nilai</b> pada baris <b>Judul Tes</b> untuk melihat nilai pada edisi tes tersebut!</li>
</ul></div>';

create_button("success", "plus-sign", "Tambah", "btn-add", "form_add()");

create_table(array("Judul Tes (Edisi)", "Tanggal", "Waktu", "Jml. Soal", "Acak Soal", "Acak Jawaban", "Soal", "Lihat Nilai", "Aksi"));

open_form("modal_tes", "return save_data()");
   create_textbox("Judul Tes (Edisi)", "judul", "text", 4, "", "required");
   create_textbox("Tanggal", "tanggal", "text", 4, "datepicker", "required");
   create_textbox("Waktu (menit)", "waktu", "number", 2, "", "required");
   create_textbox("Jml. Soal", "jml_soal", "number", 2, "", "required");

   $list = array();
   $list[] = array('Y', 'Ya');
   $list[] = array('N', 'Tidak');
   create_combobox("Acak Soal", "acak_soal", $list, 4, "", "required"); 

   $list = array();
   $list[] = array('Y', 'Ya');
   $list[] = array('N', 'Tidak');
   create_combobox("Acak Jawaban", "acak_jawaban", $list, 4, "", "required");
close_form();
?>
