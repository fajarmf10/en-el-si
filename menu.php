<?php
if (empty($_SESSION['id_tim']) or empty($_SESSION['password'])) {
    header('location: login.php');
}
?>

<div class="navbar-header">
   <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
   </button>
</div>

<div id="navbar" class="navbar-collapse collapse">
   <ul class="nav navbar-nav">
      <li><a><i class="glyphicon glyphicon-user"></i> Selamat datang, Tim <span style="text-transform: uppercase;"><?= $_SESSION['namatim'] ?></span></a></li>
   </ul>
   <ul class="nav navbar-nav navbar-right">
      <li><a href="keluar.php" class="navigation"><i class="glyphicon glyphicon-off"></i> Logout </a></li>
   </ul>
</div>
