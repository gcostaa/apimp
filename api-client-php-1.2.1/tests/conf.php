<?php
require '../vendor/autoload.php';
//require 'autoload.php';

$mapi = new Mapi\Client(
    'f06ab4dd89b720ea852547ddfa7f4f4e05b242738', /* $ConsumerKey */
    '8fd93a0d4f19166c7f8728c993fdb289', /* $ConsumerSecret */
    '6e5243602ac35173a734714dfa13fcbc05b242756', /* $Token */
    'b55c9054ffff41191a41e6625eead3d9'  /* $TokenSecret */
);

return $mapi;
