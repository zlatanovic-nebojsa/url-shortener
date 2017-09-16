<?php
session_start();

require_once 'config/database.php';

spl_autoload_register(function($className) {
   require_once 'class/' . $className . '.php';
});