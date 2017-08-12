<?php
if(empty($_SESSION['id_tim']) or empty($_SESSION['password']) ){
   header('location: login.php');
}

$edisi = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM edisi WHERE id_edisi='$_SESSION[edisi]'"));
$tes = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM tes WHERE id_tes='$_GET[id]'"));
?>

<?
//Welcoming peserta. Bantu edit
?>
<div class="col-md-8 col-md-offset-2">
<div class="padding-20">
<form action="" method="post"> 
<div class="list-group">
    <div class="list-group-item list-heading">
        <h3 class="list-group-item-heading"><b> Selamat Datang di <?= $edisi['edisi'] ?></b></h3>
    </div>
    <div class="list-group-item">
        <label class="list-group-item-heading">ID Tim</label>
        <p class="list-group-item-text"><?= $_SESSION['id_tim'] ?></p>
    </div>
    <div class="list-group-item">
        <label class="list-group-item-heading">Nama Tim</label>
        <p class="list-group-item-text"><?= $_SESSION['namatim']; ?></p>
    </div>

    <div class="list-group-item">
        <div class="row">
            <div class="col-xs-push-9 col-xs-3"><br>
         
<?php 
//Kalo udah tes, gabisa tes lagi
$qnilai = mysqli_query($mysqli, "SELECT * FROM nilai WHERE id_tes='$_GET[id]' AND id_tim='$_SESSION[id_tim]'");
$tnilai = mysqli_num_rows($qnilai);
$rnilai = mysqli_fetch_array($qnilai);

if($tnilai>0 and $rnilai['nilai'] != "")  echo '<a class="btn btn-danger btn-block disabled"> Sudah Mengerjakan </a>';
else echo '<button type="submit" name="submit" class="btn btn-success btn-block"> Lanjutkan </button>';
?>
         </div>
      </div>
    </div>
</div>
</form>
</div>
</div>
