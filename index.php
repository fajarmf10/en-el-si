<?php
session_start();
ob_start();
$lastModified = filemtime(__FILE__);
$etagFile = md5(__FILE__);

$ifModifiedSince=(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false);
$etagHeader=(isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false);

header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastModified)." GMT");
header("Etag: $etagFile");
header('Cache-Control: public');

if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])==$lastModified || $etagHeader == $etagFile)
{
       header("HTTP/1.1 304 Not Modified");
       exit;
}

if (empty($_SESSION['id_tim']) or empty($_SESSION['password'])) {
    header('location: login.php');
}
?>

<html>
<head>
   <title>Schematics ITS</title>

   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width,initial-scale=1" />

   <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
   <link type="text/css" rel="stylesheet" href="assets/dataTables/css/dataTables.bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="css/style.css"/>
   
   <script src="https://code.jquery.com/jquery-2.0.2.min.js" integrity="sha256-TZWGoHXwgqBP1AF4SZxHIBKzUdtMGk0hCQegiR99itk=" crossorigin="anonymous"></script>
   <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 </head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top"> 
   <div class="container">
      <?php
include "menu.php";
?>
   </div>
</nav>   

<section>   
   <div  class="container">
      <div class="row">
         <div class="col-xs-12" id="content"></div>
      </div>
   </div>
</section>

<footer> 
   <div class="container">
      <p class="text-center">Copyright &copy; Schematics ITS. All right reserved.</p>
   </div>
</footer>
   <script type="text/javascript" src="js/main.js"></script>

</body>
</html>
