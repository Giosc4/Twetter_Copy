<?php
 session_start();
 include_once("../server/functions.php");
 if (!isset($_SESSION['username'])) {
     header('Location: login.php');
     exit;
 }
$user_id = $_SESSION['username'];

if (isset($_POST['newFollow'])) {
    addFriend($user_id, $_POST['newFollow']);
    header('Location: ../client/home.php');
} 
if (isset($_POST['unFollow'])) {
    removeFriend($user_id, $_POST['unFollow']);
    header('Location: ../client/home.php');
}

?>