<?php
$conn = new mysqli('localhost','root','','g1');
session_start();
if(!$conn){
    echo'not connected';
}
?>