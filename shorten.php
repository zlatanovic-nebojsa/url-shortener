<?php
require_once 'core/init.php';

$s = new Shortener();

if (isset($_POST['url'])) {

    $url = trim($_POST['url']);

    if($code = $s->makeCode($url)) {
        $_SESSION['feedback'] = "Generated! Your short URL is: 
        <a href=\"http://localhost/fcc/url-shorten/{$code}\" target='_blank'>http://localhost/fcc/url-shorten/{$code}</a>";
    } else {
        // There was a problem
        $_SESSION['feedback'] = 'There was a problem. Invalid URL!';
    }
}

header('Location: index.php');