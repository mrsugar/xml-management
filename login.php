<?php

  session_start();

  if( isset($_POST['username']) && isset($_POST['password']) ){
    if( $_POST['username'] == "admin" && md5($_POST['password']) == "4f2e686b6c419ac5c1027bd49eb75608"){
      $_SESSION['isLogged'] = true;
      echo 1;
    }else {
      echo 0;
    }
  }
?>
  
?>