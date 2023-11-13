<?php 
if (session_status() == PHP_SESSION_NONE) {
    // Start session
    session_start();
}
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
    $link = "https"; 
else
    $link = "http"; 
$link .= "://"; 
$link .= $_SERVER['HTTP_HOST']; 
$link .= $_SERVER['REQUEST_URI'];

// If userdata session vaariable is not set, redirect to login page
if(!isset($_SESSION['userdata']) && !strpos($link, 'login.php') && !strpos($link, 'register.php')){
	redirect('login.php');
}

// If userdata session variable is set and the role is Buyer, redirect to buyer portal
if(isset($_SESSION['userdata']) && (strpos($link, 'login.php') || strpos($link, 'register.php')) && $_SESSION['userdata']['role'] ==  'Buyer'){
	redirect('buyer/index.php');
}

// If userdata session variable is set and the role is Agent, redirect to agent portal
if(isset($_SESSION['userdata']) && (strpos($link, 'login.php') || strpos($link, 'register.php')) && $_SESSION['userdata']['role'] ==  'Agent'){
	redirect('agent/index.php');
}
