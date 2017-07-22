<div class="navbar-header">
   <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
   </button>
</div>

<div id="navbar" class="navbar-collapse collapse">
    <ul class="nav navbar-nav">

<?php
	
function menu_admin($link, $icon, $title){
   $item = '<li><a href="'.$link.'" class="navigation"><i class="glyphicon glyphicon-'.$icon.'"></i> '.$title.'</a></li>';
   return $item;
}

if($_SESSION['leveluser'] == "admin"){
   echo menu_admin("home.php", "home", "Beranda");
   echo menu_admin("view/view_tes.php", "edit", "Tes");
   echo menu_admin("view/view_peserta.php", "list-alt", "Peserta (Tim)");
   echo menu_admin("view/view_edisi.php", "signal", "Edisi Schematics");
   echo menu_admin("view/view_edisites.php", "sort-by-attributes", "Edisi dan Tes");
}

else{ 
   echo menu_admin("home.php", "home", "Beranda");
   echo menu_admin("view/view_tes_operator.php", "edit", "Tes (Operator)");
   echo menu_admin("view/view_peserta_operator.php", "list-alt", "Peserta (Tim)");
}
?>

   </ul>
   <ul class="nav navbar-nav navbar-right">

<?php
   echo menu_admin("view/view_profil.php", "user", $_SESSION['namalengkap']);
   echo menu_admin("logout.php", "off", "Keluar");
?>

   </ul>
</div>
