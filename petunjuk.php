<?php
session_start();
ob_start();
if (empty($_SESSION['id_tim']) or empty($_SESSION['password'])) {
    header('location: login.php');
}
?>

<h3 class="page-header"><i class="glyphicon glyphicon-exclamation-sign"></i> Petunjuk Pengerjaan</h3>
<div class="alert alert-info">
<p>Baca tod:</p>

<ul>
<li>Peserta blabla</li>
</ul>

</div>

<form onsubmit="return show_tes(<?= $_GET['tes']; ?>)" class="form">
<? //Editen yo
?>
<div class="form-group">
   <div class="col-md-9">
      <input type="checkbox" required><b> Saya telah membaca dan memahami petunjuk mengerjakan dengan cermat dan teliti</b> 
   </div><br>
   <div class='col-md-3'>
      <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-log-in"></i> Mulai Tes </button>
   </div>
</div>
</form>
