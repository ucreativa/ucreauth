<?php
    if(isset($_SESSION['AUTH'])){
        if ($_SESSION["AUTH"] != "YES") {
        	   header('Location: index.php');
        }
    }else{
         header('Location: index.php');
    }
?>