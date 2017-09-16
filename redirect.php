<?php
require_once 'core/init.php';

if(isset($_GET['code'])) {
    $s = new Shortener();
    $code = trim($_GET['code']);

    if($url = $s->getUrl($code)) {
        header("Location: {$url}");
        die();
    }
}
header('Location: index.php');