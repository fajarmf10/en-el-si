<?php
session_start();
ob_start();
include "library/config.php";
include "library/function_antiinjection.php";

?>
<html>
<head>

<title>Schematics ITS - Login</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />

<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="css/style2.css"/>
	
<script type="text/javascript" src="assets/jquery/jquery-2.0.2.min.js"></script>

</head>
<body>

<nav class="navbar">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-10 judul">
				<img src="images/judul.png">
			</div>
			<div class="col-md-2 meta">
				<img src="images/avatar.gif" width="60">
				<h5>Selamat Datang!</h5>
			</div>
		</div>
	</div>
</nav>

<div class="container-fluid"> 	
   <div class="row">
 
 <div class="col-md-12">
<?php
if(isset($_POST['username'])){
	
	$username = antiinjeksi($_POST['username']);
	$password = antiinjeksi(md5($_POST['password']));

	$cekuser = mysqli_query($mysqli, "SELECT * FROM peserta WHERE id_tim='$username' AND password='$password'");
	$jmluser = mysqli_num_rows($cekuser);
	$data = mysqli_fetch_array($cekuser);
	if(empty($username)){
		echo '<div class="alert alert-danger" role="alert">Username harus diisi!</div>';
	}elseif(empty($username)){
		echo '<div class="alert alert-danger" role="alert">Password harus diisi!</div>';
	}elseif($jmluser > 0){
	   if($data['status'] == "off"){
		 $_SESSION['username']		= $data['id_tim'];
		 $_SESSION['namatim']		= $data['nama'];
		 $_SESSION['password']		= $data['password'];
		 $_SESSION['id_tim']		= $data['id_tim'];
		 $_SESSION['edisi']			= $data['id_edisi'];

		 mysqli_query($mysqli, "UPDATE peserta SET status='on' WHERE id_tim='$data[id_tim]'");
		 echo '<div class="alert alert-success" role="alert">Login berhasil</div>';
		 header('location: index.php');
		
	   }else{
		  echo "Tim sedang <b>Login</b>. Hubungi panitia untuk informasi lebih lanjut!";
	   }
	}else{
		echo "<b>ID Tim</b> atau <b>password</b> tidak terdaftar!</br>Jika merasa ada kesalahan, silahkan hubungi panitia.";
	}
}
?>
</div>

<div class="col-md-4 col-md-offset-4">

<div class="panel panel-default form-login">
   <div class="panel-heading">
      <h3><b>Login Schematics</b></h3>
   </div>
   <div class="panel-body">
				  
<form class="form form-horizontal" method="post">   
   <div class="form-group">
		<div class="control-label col-md-3" for="username">ID Tim</div>
		<div class="col-md-9">
	    <div class="input-group">
		  <div class="input-group-addon icon-username"><i class="glyphicon glyphicon-user"></i></div>
		  <input type="text" name="username" id="username" placeholder="ID Tim" autofocus class="form-control">
	    </div>
		</div>
   </div>
	
    <div class="form-group">
		<div class="control-label col-md-3" for="password">Password</div>
		<div class="col-md-9">
	   <div class="input-group">
		  <div class="input-group-addon icon-password"><i class="glyphicon glyphicon-lock"></i></div>
		  <input type="password" name="password" id="password" placeholder="Password" class="form-control">
	   </div>
	   </div>
	</div>
	<div class="col-md-offset-3">
		<div class="login-button">
		   <button class="btn btn-success btn-block form-control">
			  LOGIN
		   </button>
		</div>
	</div>
</form>
 
   </div>
   <div class="panel-footer">
   
   </div>
</div>


      </div>
   </div>
</div>

<footer class="footer-login"> 
   <div class="container">
      <p class="text-center">Copyright &copy; Schematics ITS. All right reserved.</p>
   </div>
</footer>
</body>
</html>
