<?php

require_once('../useraccounts-master/config.php');
session_start();

if(isset($_POST['username'])){
    echo $_POST['username'];
    $username = $_POST['username'];
      
    $db->prepare("DELETE FROM user_accounts WHERE username=?")->execute([$username]);
    $db->prepare("DELETE FROM user_data WHERE username=?")->execute([$username]);
    session_destroy();
    unset($_SESSION);
    header("Location: ../useraccounts-master/login.php");
}
    