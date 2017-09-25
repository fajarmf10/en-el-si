<?php
session_start();
include "library/config.php";
include "library/function_noinject.php";

$id_tim   = antiinjeksi($_POST['id_tim']);
$password = antiinjeksi(md5($_POST['password']));


# check if user with this id already fetched in db.
$pre_cekuser = mysqli_query ($mysqli, "SELECT * FROM peserta WHERE id_tim='$id_tim' AND password='$password'");
$pre_jmluser = mysqli_num_rows ($pre_cekuser);

if ($pre_jmluser == 0) {
    # user data does not exist, forward login to schematics.its.ac.id.
    $api_url = 'http://schematics.its.ac.id/api/login';
    $link = new mysqli ($host, $user, $pass, $db);

    $login_request = curl_init ();
    curl_setopt_array ($login_request, array (
        CURLOPT_URL => $api_url,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERAGENT => "en el si on len",
        CURLOPT_POSTFIELDS => array (
            'id' => $id_tim,
            'password' => $_POST['password']
        )
    ));

    # check login response. put data to table (db) upon success.
    $namatim = curl_exec ($login_request);
    if ($namatim) {
        # the credentials supplied are valid, put it to db.
        mysqli_query ($link, "INSERT INTO peserta VALUES ('$id_tim',
                                                          '$namatim',
                                                          '$password',
                                                          'schematics',
                                                          'off')");
    }
    
    curl_close ($login_request);
}


$cekuser = mysqli_query($mysqli, "SELECT * FROM peserta WHERE id_tim='$id_tim' AND password='$password'");
$jmluser = mysqli_num_rows($cekuser);
$data    = mysqli_fetch_array($cekuser);
if ($jmluser > 0) {
    if ($data['status'] == "off") {
        /*
        
        $_SESSION['username']    = $data['id_tim'];
        $_SESSION['namatim']   = $data['nama'];
        $_SESSION['password']    = $data['password'];
        $_SESSION['edisi']     = $data['id_edisi'];
        */
        
        $_SESSION['id_tim']   = $data['id_tim'];
        $_SESSION['namatim']  = $data['nama'];
        $_SESSION['password'] = $data['password'];
        $_SESSION['edisi']    = $data['id_edisi'];
        
        mysqli_query($mysqli, "UPDATE peserta SET status='on' WHERE id_tim='$data[id_tim]'");
        echo "ok";
    } else {
        echo "Tim sedang <b>Login</b>. Hubungi panitia untuk informasi lebih lanjut!";
    }
} else {
    echo "<b>ID Tim</b> atau <b>password</b> tidak terdaftar!</br>Jika merasa ada kesalahan, silahkan hubungi panitia.";
}
?>