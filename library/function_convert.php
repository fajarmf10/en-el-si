<?php
function hoursminute($time, $format = '%02d:%02d') {
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}

function minutehours($jam, $menit, $detik) {
    if ($jam>1){
        $menitku=$jam*60;
    }
    else {
        $menitku=0;
    }
    $hasil = '%02d:%02d';
    return sprintf($hasil, $menit+$menitku, $detik);
}

function timeseconds($menit, $detik)
{
    if ($menit>0){
        $detikku=$menit*60;
    }
    else {
        $detikku=0;
    }
    $hasil = '%02d';
    return sprintf($hasil, $detik+$detikku);
}

function dateseconds($jam, $menit, $detik){
    $detikku=0;
    if ($jam>0){
        $detikku+=$jam*3600;
    }
    if ($menit>0){
        $detikku+=$menit*60;
    }
    $hasil = '%02d';
    return sprintf($hasil, $detikku+$detik);
}

function secondshour($detik){
    $menitku=$detik/60;
    $detik=$detik%60;
    $hasil = '%02d:%02d';
    return sprintf($hasil, $menitku, $detik);
}