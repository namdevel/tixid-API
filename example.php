<?php 
require('src/Tix.php');

$token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJtc2lz....'; //echo $tix->getAuthToken();
$tix   = new TixID($token);

echo $tix->getCities();
echo $tix->getAuthToken();
echo $tix->getPromoBanner();
echo $tix->nowPlaying();
echo $tix->tixNow();
echo $tix->movieSchedule();
echo $tix->movieInfo('1394500495057440768');
echo $tix->movieRate('1394500495057440768');